// ===== Hamburger menu =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Modal konfirmasi =====
let modalResolve = null;

function askConfirm(title, message) {
    return new Promise(resolve => {
        const overlay = document.getElementById("modal-confirm");
        document.getElementById("modal-title").textContent = title;
        document.getElementById("modal-message").textContent = message;
        overlay.classList.add("is-open");
        modalResolve = resolve;
    });
}

function initModal() {
    const overlay = document.getElementById("modal-confirm");
    if (!overlay) return;
    document.getElementById("modal-cancel").addEventListener("click", () => {
        overlay.classList.remove("is-open");
        if (modalResolve) modalResolve(false);
    });
    document.getElementById("modal-ok").addEventListener("click", () => {
        overlay.classList.remove("is-open");
        if (modalResolve) modalResolve(true);
    });
}

// ===== Konfirmasi hapus =====
function initHapusConfirm() {
    document.addEventListener("submit", async (e) => {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;
        e.preventDefault();
        const row = form.closest("tr");
        // Ambil kolom pertama (No. Anggota / Judul) sebagai label
        const label = row ? (row.querySelectorAll("td")[0]?.textContent.trim() || "data ini") : "data ini";
        const ok = await askConfirm("Konfirmasi Hapus", `Yakin ingin menghapus "${label}"?`);
        if (ok) form.submit();
    });
}

// ===== Toast =====
function showToast(message, type = "info") {
    const container = document.getElementById("toast-container");
    if (!container) return;
    const t = document.createElement("div");
    t.className = "toast toast-" + type;
    t.textContent = message;
    container.appendChild(t);
    setTimeout(() => t.remove(), 3500);
}

// ===== Filter tabel (fallback non-JS search) =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;
    // Hanya jalankan filter lokal kalau form TIDAK pakai AJAX
    const form = input.closest("form");
    if (form && form.dataset.ajax) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Validasi form =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) next.remove();
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah") || document.getElementById("form-edit");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const judul = form.querySelector("[name='judul'], [name='nama']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) hapusError(judul);

        const pengarang = form.querySelector("[name='pengarang']");
        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(pengarang, "Pengarang wajib diisi.");
            valid = false;
        } else if (pengarang) hapusError(pengarang);

        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else hapusError(tahun);
        }

        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else hapusError(stok);
        }

        if (!valid) e.preventDefault();
    });
}

// ===== AJAX search =====
function escapeHtml(str) {
    return String(str ?? "")
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#39;");
}

function initAjaxSearch() {
    const form = document.querySelector(".search-box form[data-ajax]");
    if (!form) return;
    const input = form.querySelector("input[type='text']");
    const tbody = document.querySelector(".table-responsive tbody");
    const table = document.querySelector(".table-responsive table");
    const endpoint = form.dataset.ajax;
    let timer = null;

    // Deteksi jenis tabel dari header
    const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.textContent.trim().toLowerCase());
    const isAnggota = headers.includes("no. anggota");

    input.addEventListener("input", () => {
        clearTimeout(timer);
        timer = setTimeout(async () => {
            try {
                const res = await fetch(endpoint + "?q=" + encodeURIComponent(input.value.trim()));
                if (!res.ok) throw new Error("HTTP " + res.status);
                const json = await res.json();
                renderRows(json.data);
            } catch (err) {
                showToast("Gagal memuat data", "error");
            }
        }, 300);
    });

    form.addEventListener("submit", (e) => e.preventDefault());

    function renderRows(rows) {
        if (!rows || !rows.length) {
            tbody.innerHTML = '<tr><td colspan="99" style="text-align:center;color:#64748b;">Tidak ada data.</td></tr>';
            return;
        }

        if (isAnggota) {
            tbody.innerHTML = rows.map(r => `
                <tr>
                    <td>${escapeHtml(r.no_anggota)}</td>
                    <td>${escapeHtml(r.nama)}</td>
                    <td>${escapeHtml(r.email)}</td>
                    <td>${escapeHtml(r.alamat)}</td>
                    <td>${escapeHtml(r.no_hp)}</td>
                    <td>
                        <a href="edit.php?id=${encodeURIComponent(r.id)}" class="btn btn-edit">Edit</a>
                        <form class="form-hapus" method="post" action="hapus.php" style="display:inline;">
                            <input type="hidden" name="id" value="${escapeHtml(r.id)}">
                            <button type="submit" class="btn btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
            `).join("");
        } else {
            tbody.innerHTML = rows.map(r => `
                <tr>
                    <td>${escapeHtml(r.judul)}</td>
                    <td>${escapeHtml(r.pengarang)}</td>
                    <td>${escapeHtml(r.tahun)}</td>
                    <td>${escapeHtml(r.stok)}</td>
                    <td>
                        <a href="edit.php?id=${encodeURIComponent(r.id)}" class="btn btn-edit">Edit</a>
                        <form class="form-hapus" method="post" action="hapus.php" style="display:inline;">
                            <input type="hidden" name="id" value="${escapeHtml(r.id)}">
                            <button type="submit" class="btn btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
            `).join("");
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initModal();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    initAjaxSearch();

    if (window.__FLASH__ && window.__FLASH__.pesan) {
        showToast(window.__FLASH__.pesan, window.__FLASH__.type || "info");
    }
});