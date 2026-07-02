const heroCubes = document.querySelector('.hero-cubes')

// get width and height of the div
const width = heroCubes.getBoundingClientRect().width
const height = heroCubes.getBoundingClientRect().height

const divideW = Math.ceil(width / 100)
const divideH = Math.ceil(height / 100)

const grid = Array(divideH).fill(null).map(() => Array(divideW).fill(null))

// Augmenter légèrement le ratio de bleu
const blueRatio = 0.25

const totalCubes = divideW * divideH
const targetBlueCubes = Math.floor(totalCubes * blueRatio)
let blueCubesPlaced = 0

// Créer les groupes de cubes bleus
while (blueCubesPlaced < targetBlueCubes) {
    const row = Math.floor(Math.random() * divideH)
    const col = Math.floor(Math.random() * divideW)

    if (!grid[row][col] && !hasTooManyBluesAround(grid, row, col)) {
        // Créer systématiquement un groupe
        const groupSize = Math.floor(Math.random() * 3) + 2 // Groupe de 2 à 4 cubes
        let groupPlaced = 0

        // Placement du cube central
        grid[row][col] = 'blue'
        blueCubesPlaced++
        groupPlaced++

        // Directions possibles (incluant les diagonales)
        const directions = [
            [0,1], [1,0], [1,1], [-1,0],
            [0,-1], [-1,-1], [1,-1], [-1,1]
        ]

        // Mélanger les directions pour un placement aléatoire
        directions.sort(() => Math.random() - 0.5)

        // Placer les cubes adjacents
        for (const [dx, dy] of directions) {
            if (groupPlaced >= groupSize) break

            const newRow = row + dx
            const newCol = col + dy

            if (isValidPosition(newRow, newCol, divideH, divideW) &&
                !grid[newRow][newCol] &&
                !hasTooManyBluesAround(grid, newRow, newCol)) {
                grid[newRow][newCol] = 'blue'
                blueCubesPlaced++
                groupPlaced++

                // Chance de créer une extension du groupe
                if (Math.random() < 0.4) {
                    const extRow = newRow + dx
                    const extCol = newCol + dy
                    if (isValidPosition(extRow, extCol, divideH, divideW) &&
                        !grid[extRow][extCol] &&
                        !hasTooManyBluesAround(grid, extRow, extCol)) {
                        grid[extRow][extCol] = 'blue'
                        blueCubesPlaced++
                        groupPlaced++
                    }
                }
            }
        }
    }
}

// Remplir le reste avec du rouge
for (let i = 0; i < divideH; i++) {
    for (let j = 0; j < divideW; j++) {
        const cube = document.createElement('div')

        if (!grid[i][j]) {
            grid[i][j] = 'red'
        }

        cube.classList.add("hero-cubes__i")
        cube.setAttribute("data-color", grid[i][j])
        cube.style.width = '100px'
        cube.style.height = '100px'
        cube.style.left = (j * 100) + 'px'
        cube.style.top = (i * 100) + 'px'

        heroCubes.appendChild(cube)
    }
}

function isValidPosition(row, col, maxRow, maxCol) {
    return row >= 0 && row < maxRow && col >= 0 && col < maxCol
}

function hasTooManyBluesAround(grid, row, col) {
    let blueCount = 0
    const radius = 2

    for (let i = Math.max(0, row - radius); i <= Math.min(grid.length - 1, row + radius); i++) {
        for (let j = Math.max(0, col - radius); j <= Math.min(grid[0].length - 1, col + radius); j++) {
            if (grid[i][j] === 'blue') {
                blueCount++
                if (blueCount > 4) return true // Augmenté pour permettre des groupes plus grands
            }
        }
    }
    return false
}
