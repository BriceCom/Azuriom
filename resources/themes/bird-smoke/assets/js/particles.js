class BackgroundParticles {
    constructor(options = {}) {
        this.canvas = null;
        this.ctx = null;
        this.particles = [];
        this.animationFrame = null;

        this.config = {
            enabled: options.enabled || false,
            count: parseInt(options.count) || 50,
            density: parseInt(options.density) || 800,
            speed: parseFloat(options.speed) || 3,
            size: parseFloat(options.size) || 3,
            image: options.image || null,
            color: options.color || 'rgba(255, 255, 255, 0.8)'
        };

        this.imageLoaded = false;
        this.particleImage = null;

        if (this.config.enabled) {
            this.init();
        }
    }

    init() {
        this.createCanvas();
        this.loadImage();
        this.createParticles();
        this.setupEventListeners();
        this.animate();
    }

    createCanvas() {
        const existingCanvas = document.getElementById('particles-canvas');
        if (existingCanvas) {
            existingCanvas.remove();
        }

        this.canvas = document.createElement('canvas');
        this.canvas.id = 'particles-canvas';
        this.canvas.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 99;
            opacity: 0.6;
        `;

        document.body.appendChild(this.canvas);
        this.ctx = this.canvas.getContext('2d');

        this.resizeCanvas();
    }

    resizeCanvas() {
        if (!this.canvas) return;

        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    loadImage() {
        if (this.config.image && this.config.image.trim() !== ''){

            this.particleImage = new Image();
            this.particleImage.crossOrigin = 'anonymous';

            this.particleImage.onload = () => {
                this.imageLoaded = true;
            };

            this.particleImage.src = this.config.image;
        }
    }

    createParticles() {
        this.particles = [];

        for (let i = 0; i < this.config.count; i++) {
            this.particles.push(this.createParticle());
        }
    }

    createParticle() {
        return {
            x: Math.random() * (this.canvas ? this.canvas.width : window.innerWidth),
            y: Math.random() * (this.canvas ? this.canvas.height : window.innerHeight),
            size: (Math.random() * this.config.size) + 1,
            speedX: (Math.random() - 0.5) * this.config.speed * 0.5,
            speedY: Math.random() * this.config.speed + 1,
            opacity: Math.random() * 0.5 + 0.5,
            rotation: Math.random() * 360,
            rotationSpeed: (Math.random() - 0.5) * 2
        };
    }

    updateParticles() {
        if (!this.canvas) return;

        this.particles.forEach(particle => {
            particle.x += particle.speedX;
            particle.y += particle.speedY;
            particle.rotation += particle.rotationSpeed;

            if (particle.y > this.canvas.height + 10) {
                particle.y = -10;
                particle.x = Math.random() * this.canvas.width;
            }

            if (particle.x > this.canvas.width + 10) {
                particle.x = -10;
            } else if (particle.x < -10) {
                particle.x = this.canvas.width + 10;
            }

            particle.opacity += (Math.random() - 0.5) * 0.01;
            particle.opacity = Math.max(0.2, Math.min(0.8, particle.opacity));
        });
    }

    drawParticles() {
        if (!this.canvas || !this.ctx) return;

        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        this.particles.forEach(particle => {
            this.ctx.save();
            this.ctx.globalAlpha = particle.opacity;
            this.ctx.translate(particle.x, particle.y);
            this.ctx.rotate((particle.rotation * Math.PI) / 180);

            if (this.imageLoaded && this.particleImage) {
                const size = particle.size * 5;
                this.ctx.drawImage(
                    this.particleImage,
                    -size / 2,
                    -size / 2,
                    size,
                    size
                );
            } else {
                this.ctx.beginPath();
                this.ctx.arc(0, 0, particle.size, 0, Math.PI * 2);
                this.ctx.fillStyle = this.config.color;
                this.ctx.fill();
            }

            this.ctx.restore();
        });
    }

    animate() {
        this.updateParticles();
        this.drawParticles();

        this.animationFrame = requestAnimationFrame(() => this.animate());
    }

    setupEventListeners() {
        window.addEventListener('resize', () => {
            this.resizeCanvas();
            this.createParticles();
        });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pause();
            } else {
                this.resume();
            }
        });
    }

    pause() {
        if (this.animationFrame) {
            cancelAnimationFrame(this.animationFrame);
            this.animationFrame = null;
        }
    }

    resume() {
        if (!this.animationFrame && this.config.enabled) {
            this.animate();
        }
    }

    destroy() {
        this.pause();

        if (this.canvas) {
            this.canvas.remove();
            this.canvas = null;
            this.ctx = null;
        }

        this.particles = [];

        window.removeEventListener('resize', this.resizeCanvas);
    }

    updateConfig(newConfig) {
        this.config = { ...this.config, ...newConfig };

        if (this.config.enabled) {
            if (!this.canvas) {
                this.init();
            } else {
                this.loadImage();
                this.createParticles();
                if (!this.animationFrame) {
                    this.animate();
                }
            }
        } else {
            this.destroy();
        }
    }
}

let backgroundParticles = null;

function initBackgroundParticles() {
    if (typeof window.THEME !== 'undefined' && window.THEME.particles) {
        const config = window.THEME.particles;

        if (backgroundParticles) {
            backgroundParticles.destroy();
        }

        backgroundParticles = new BackgroundParticles(config);
    }
}

window.BackgroundParticles = BackgroundParticles;
window.initBackgroundParticles = initBackgroundParticles;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBackgroundParticles, { once: true });
} else {
    initBackgroundParticles();
}
