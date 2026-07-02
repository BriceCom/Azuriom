document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('scratch-layer');

    if (!canvas) {
        return;
    }

    const board = document.getElementById('scratch-board');
    const content = document.getElementById('scratch-content');
    const alertsContainer = document.getElementById('scratch-alerts');
    const rewardName = document.getElementById('reward-name');
    const rewardExtra = document.getElementById('reward-extra');
    const rewardImageWrap = document.getElementById('reward-image-wrap');
    const rewardImage = document.getElementById('reward-image');
    const remainingPointsValue = document.getElementById('remaining-points-value');

    const ctx = canvas.getContext('2d', { willReadFrequently: true });
    const coverUrl = canvas.dataset.cover;
    const label = canvas.dataset.label || 'Scratch';
    const claimUrl = canvas.dataset.claimUrl;
    const csrfToken = canvas.dataset.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    let drawing = false;
    let revealDone = false;
    let claimRequested = false;
    let moveCounter = 0;

    const clamp = (value, min, max) => Math.max(min, Math.min(max, value));

    const writeLabel = () => {
        ctx.fillStyle = 'rgba(0, 0, 0, 0.6)';
        ctx.font = '700 24px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(label, canvas.width / 2, canvas.height / 2);
    };

    const drawImageCover = (image) => {
        if (image.width <= 0 || image.height <= 0) {
            return false;
        }

        // Keep the scratch layer opaque even with transparent PNGs.
        ctx.fillStyle = '#ced4da';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        const scale = Math.max(canvas.width / image.width, canvas.height / image.height);
        const drawWidth = image.width * scale;
        const drawHeight = image.height * scale;
        const drawX = (canvas.width - drawWidth) / 2;
        const drawY = (canvas.height - drawHeight) / 2;

        ctx.drawImage(image, drawX, drawY, drawWidth, drawHeight);

        return true;
    };

    const resizeCanvas = () => {
        canvas.width = board.clientWidth;
        canvas.height = board.clientHeight;

        if (!coverUrl) {
            ctx.fillStyle = '#ced4da';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            writeLabel();

            return;
        }

        const image = new Image();
        image.onload = function () {
            const rendered = drawImageCover(image);

            if (!rendered) {
                ctx.fillStyle = '#ced4da';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                writeLabel();
            }
        };
        image.onerror = function () {
            ctx.fillStyle = '#ced4da';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            writeLabel();
        };
        image.src = coverUrl;
    };

    const scratch = (x, y) => {
        ctx.globalCompositeOperation = 'destination-out';
        ctx.beginPath();
        ctx.arc(x, y, 16, 0, Math.PI * 2);
        ctx.fill();
        ctx.globalCompositeOperation = 'source-over';

        moveCounter++;
        if (moveCounter % 12 === 0) {
            checkReveal();
        }
    };

    const getPointFromEvent = (event) => {
        const rect = canvas.getBoundingClientRect();
        const source = event.touches ? event.touches[0] : event;

        if (!source) {
            return null;
        }

        return {
            x: clamp(source.clientX - rect.left, 0, canvas.width),
            y: clamp(source.clientY - rect.top, 0, canvas.height),
        };
    };

    const appendAlerts = (messages, type) => {
        if (!Array.isArray(messages) || messages.length === 0) {
            return;
        }

        const alert = document.createElement('div');
        alert.className = `alert alert-${type} text-start`;
        const list = document.createElement('ul');
        list.className = 'mb-0 ps-3';

        messages.forEach((message) => {
            const li = document.createElement('li');
            li.textContent = message;
            list.appendChild(li);
        });

        alert.appendChild(list);
        alertsContainer.appendChild(alert);
    };

    const showResult = (payload) => {
        if (payload.reward) {
            rewardName.textContent = payload.reward.name;

            if (payload.reward.image) {
                rewardImage.src = payload.reward.image;
                rewardImage.alt = payload.reward.name;
                rewardImageWrap.classList.remove('d-none');
            } else {
                rewardImageWrap.classList.add('d-none');
            }

            rewardExtra.className = 'mb-0';
            rewardExtra.textContent = '';
        } else {
            rewardImageWrap.classList.add('d-none');
            rewardName.textContent = content.dataset.noReward;
            rewardExtra.className = 'mb-0 text-muted';
            rewardExtra.textContent = content.dataset.tryAgain;
        }

        if (remainingPointsValue && payload.remaining_money !== undefined) {
            remainingPointsValue.textContent = Number(payload.remaining_money).toFixed(2);
        }

        appendAlerts(payload.warnings || [], 'warning');
        appendAlerts(payload.errors || [], 'danger');
    };

    const claimReward = async () => {
        if (claimRequested) {
            return;
        }

        claimRequested = true;
        rewardName.textContent = content.dataset.revealing;
        rewardExtra.textContent = '';

        try {
            const response = await fetch(claimUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken || '',
                },
            });

            if (!response.ok) {
                let errorMessage = content.dataset.revealError;

                try {
                    const errorPayload = await response.json();
                    if (typeof errorPayload?.message === 'string' && errorPayload.message.trim() !== '') {
                        errorMessage = errorPayload.message;
                    }
                } catch (e) {
                    // Keep generic translated fallback message.
                }

                throw new Error(errorMessage);
            }

            const payload = await response.json();
            showResult(payload);
        } catch (error) {
            const message = error?.message || content.dataset.revealError;
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger mb-0';
            alert.textContent = message;
            alertsContainer.appendChild(alert);
            rewardName.textContent = message;
            rewardExtra.textContent = '';
        }
    };

    const finalizeReveal = () => {
        if (revealDone) {
            return;
        }

        revealDone = true;
        canvas.style.transition = 'opacity 280ms ease';
        canvas.style.opacity = '0';

        setTimeout(() => {
            canvas.style.display = 'none';
            claimReward();
        }, 300);
    };

    const checkReveal = () => {
        if (revealDone) {
            return;
        }

        const pixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const totalPixels = pixels.data.length / 4;
        let transparentPixels = 0;

        for (let i = 3; i < pixels.data.length; i += 4) {
            if (pixels.data[i] < 120) {
                transparentPixels++;
            }
        }

        if (transparentPixels / totalPixels > 0.52) {
            finalizeReveal();
        }
    };

    const handleMove = (event) => {
        if (!drawing) {
            return;
        }

        const point = getPointFromEvent(event);

        if (!point) {
            return;
        }

        scratch(point.x, point.y);

        if (event.touches) {
            event.preventDefault();
        }
    };

    canvas.addEventListener('mousedown', function (event) {
        drawing = true;
        handleMove(event);
    });

    canvas.addEventListener(
        'touchstart',
        function (event) {
            drawing = true;
            handleMove(event);
            event.preventDefault();
        },
        { passive: false }
    );

    document.addEventListener('mousemove', handleMove);
    document.addEventListener('touchmove', handleMove, { passive: false });

    document.addEventListener('mouseup', function () {
        drawing = false;
    });

    document.addEventListener('touchend', function () {
        drawing = false;
    });

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
});
