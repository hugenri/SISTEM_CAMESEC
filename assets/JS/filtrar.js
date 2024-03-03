
function filtrar(tabla){


    const input = document.getElementById("searchInput");
    const table = document.getElementById(tabla);
    const rows = table.getElementsByTagName("tr");

    input.addEventListener("input", function() {
        const searchText = input.value.toLowerCase();

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let rowContainsSearchText = false;

            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toLowerCase();
                if (cellText.includes(searchText)) {
                    rowContainsSearchText = true;
                    break;
                }
            }

            if (rowContainsSearchText) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    });
}