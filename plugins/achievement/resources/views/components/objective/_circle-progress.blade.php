@props([
    'radius' => 75,
    'percent' => 0,
    'strokeWidth' => 8,
    'bsPrefix' => "bs",
    'strokeColorCurrent' => "primary",
    'strokeColorSuccess' => "success",
    'legend' => "",
])

<div id="chart-1" class="circle-chart"
     style="width: {{ $radius }}px; height: {{ $radius }}px;"
     data-radius="{{ $radius }}"
     data-percent="{{ $percent }}"
     data-stroke-width="{{ $strokeWidth }}"
     data-stroke-color-current="var(--{{ $bsPrefix }}-{{ $strokeColorCurrent }})"
     data-stroke-color-success="var(--{{ $bsPrefix }}-{{ $strokeColorSuccess }})"
     data-legend="{{ $legend }}">
</div>


@push("footer-scripts")
    <script>
        function createCircleProgress(el) {
            const radius = parseFloat(el.dataset.radius) || 72;
            const percent = parseFloat(el.dataset.percent) || 0;
            const strokeWidth = parseFloat(el.dataset.strokeWidth) || 8;
            const strokeColorCurrent = el.dataset.strokeColorCurrent;
            const strokeColorSuccess = el.dataset.strokeColorSuccess;
            const legend = el.dataset.legend || "";

            const circumference = 2 * Math.PI * radius;

            // Reset content
            el.innerHTML = "";
            el.classList.add("position-relative", "d-grid", "justify-content-center", "align-items-center");

            // SVG setup
            const svgNS = "http://www.w3.org/2000/svg";
            const svg = document.createElementNS(svgNS, "svg");
            svg.setAttribute("width", radius);
            svg.setAttribute("height", radius);
            svg.setAttribute(
                "viewBox",
                `-${strokeWidth / 2} -${strokeWidth / 2} ${radius * 2 + strokeWidth} ${radius * 2 + strokeWidth}`
            );
            svg.style.transform = "rotate(-90deg)";

            // Background circle
            const bgCircle = document.createElementNS(svgNS, "circle");
            bgCircle.setAttribute("cx", radius);
            bgCircle.setAttribute("cy", radius);
            bgCircle.setAttribute("r", radius);
            bgCircle.setAttribute("stroke", "var(--{{$bsPrefix}}-border-color-translucent)");
            bgCircle.setAttribute("stroke-width", strokeWidth);
            bgCircle.setAttribute("fill", "none");

            // Progress circle
            const progressCircle = document.createElementNS(svgNS, "circle");
            progressCircle.setAttribute("cx", radius);
            progressCircle.setAttribute("cy", radius);
            progressCircle.setAttribute("r", radius);
            progressCircle.setAttribute("stroke", percent === 100 ? strokeColorSuccess : strokeColorCurrent);
            progressCircle.setAttribute("stroke-width", strokeWidth);
            progressCircle.setAttribute("stroke-dasharray", circumference);
            progressCircle.setAttribute(
                "stroke-dashoffset",
                circumference - (circumference * percent) / 100
            );
            progressCircle.setAttribute("fill", "none");

            // Append circles
            svg.appendChild(bgCircle);
            svg.appendChild(progressCircle);

            // Text container
            const textContainer = document.createElement("div");
            textContainer.className = "position-absolute top-50 start-50 translate-middle text-center";

            // Percent text
            const percentText = document.createElement("span");
            percentText.className = "";
            percentText.textContent = `${percent}%`;
            textContainer.appendChild(percentText);

            // Legend text
            if (legend) {
                const legendText = document.createElement("div");
                legendText.className = "text-muted small";
                legendText.textContent = legend;
                textContainer.appendChild(legendText);
            }

            // Append to element
            el.appendChild(svg);
            el.appendChild(textContainer);
        }

        // Initialize all charts
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".circle-chart").forEach(chart => {
                createCircleProgress(chart);
            });
        });
    </script>
@endpush
