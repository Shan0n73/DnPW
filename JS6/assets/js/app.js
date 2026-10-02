// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.querySelector("header nav");

  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
  });
}

// ===== Konfirmasi hapus =====
function initHapusConfirm() {
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;

    const row = btn.closest("tr");
    const nama = row ? row.querySelector("td")?.textContent : "data ini";
    const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');

    if (yakin && row) {
      row.remove();

        /* JS5 Lat 4 - update row counter setelah dihapus */
        updateRowCounter();
      }
    });
  };


// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
  const input = document.getElementById("search-input");
  const table = document.querySelector(".table-responsive table");

  if (!input || !table) return;

  input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase();
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(function (row) {
      
      // JS5 Lat 3 - membuat pencarian bisa di batasi ke satu kolom (misalnya judul)
      const tdJudul = row.querySelector("td");
      const teks = tdJudul ? tdJudul.textContent.toLowerCase() : row.textContent.toLowerCase();

      row.style.display = teks.includes(keyword) ? "" : "none";
    });

    /* JS5 Lat 4 - update row counter setelah di filter */
    updateRowCounter();
  });
}

/* JS5 Lat 4 - row counter */
function updateRowCounter() {
  const table = document.querySelector(".table-responsive table");
  let counterDiv = document.getElementById("table-counter");

  if (!table) return;

  // Membuat elemen .row-counter jika belum ada di HTML
  if (!counterDiv) {
    counterDiv = document.createElement("div");
    counterDiv.id = "table-counter";
    counterDiv.className = "row-counter";
    table.parentElement.insertAdjacentElement("beforebegin", counterDiv);
  }

  const totalRows = table.querySelectorAll("tbody tr").length;
  const visibleRows = Array.from(table.querySelectorAll("tbody tr")).filter(
    (row) => row.style.display !== "none"
  ).length;

  counterDiv.textContent = `Menampilkan ${visibleRows} dari ${totalRows} data`;
}

// ===== Validasi form helper =====
function tampilkanError(input, pesan) {
  hapusError(input);
  const span = document.createElement("span");
  span.className = "error";
  span.textContent = pesan;
  input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
  const next = input.nextElementSibling;
  if (next && next.classList.contains("error")) {
    next.remove();
  }
}

// ===== Validasi form utama =====
function initValidasiForm() {
  const form = document.getElementById("form-tambah");

  if (!form) return;

  form.addEventListener("submit", function (e) {
    let valid = true;

    /* JS5 Lat 5 - refactor validasi */
    const validationRules = [
      {
        selector: "[name='judul'], [name='nama']",
        validate: (val) => val.trim() !== "",
        message: "Field ini wajib diisi."
      },
      {
        selector: "[name='pengarang']",
        validate: (val) => val.trim() !== "",
        message: "Field ini wajib diisi."
      },
      {
        selector: "[name='tahun']",
        validate: (val) => {
          const nilai = parseInt(val, 10);
          return !isNaN(nilai) && nilai >= 1900 && nilai <= 2026;
        },
        message: "Tahun harus di antara 1900-2026."
      },
      {
        selector: "[name='stok']",
        validate: (val) => {
          const nilai = parseInt(val, 10);
          return !isNaN(nilai) && nilai >= 0;
        },
        message: "Stok tidak boleh negatif."
      },

      // JS5 Lat 1 - validasi pembatasan karakter unutk ISBN (Hanya 0-9 dan tanda hubung (-) ).
      {
        selector: "[name='isbn']",
        validate: (val) => {
          if (val.trim() === "") return true;
          const regexISBN = /^[0-9-]+$/;
          return regexISBN.test(val.trim());
        },
        message: "ISBN hanya boleh berisi angka dan tanda hubung (-)."
      }
    ];

    /* JS5 Lat 5 -  menggunakan foreach untuk pola perulangannya */
    validationRules.forEach((rule) => {
      const field = form.querySelector(rule.selector);
      if (field) {
        if (!rule.validate(field.value)) {
          tampilkanError(field, rule.message);
          valid = false;
        } else {
          hapusError(field);
        }
      }
    });

    if (!valid) {
      e.preventDefault();
    }
  });
}

// ===== Entry Point / Titik Masuk Utama =====
document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initHapusConfirm();
  initTableFilter();
  initValidasiForm();

  /* JS5 Lat 4 - inisiasi row counter*/
  updateRowCounter();
});