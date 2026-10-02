
// Lat 2 - penggabungan anggota.js dan buku.js menjadi 1 fungsi generik
async function muatDataGenerik(urlData, daftarKunci) {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");

    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch(urlData);
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        const dataList = await res.json();

        dataList.forEach(function (item) {
            const tr = document.createElement("tr");
            
            // Render/load sel berdasarkan array kunci yang diberikan
            let htmlContent = "";
            daftarKunci.forEach(function (kunci) {
                htmlContent += "<td>" + (item[kunci] !== undefined ? item[kunci] : "") + "</td>";
            });

            // Kolom aksi edit/hapus
            htmlContent += "<td>" +
                '<button type="button">Edit</button> ' +
                '<button type="button" class="btn-hapus">Hapus</button>' +
                "</td>";

            tr.innerHTML = htmlContent;
            tbody.appendChild(tr);
        });

        if (typeof updateRowCounter === "function") {
            updateRowCounter();
        }
    } catch (err) {
        tbody.innerHTML = '<tr><td colspan="' + (daftarKunci.length + 1) + '">Gagal memuat data: ' + err.message + '</td></tr>';
    } finally {
        if (loading) loading.style.display = "none";
    }
}