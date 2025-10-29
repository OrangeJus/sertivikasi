document.addEventListener('DOMContentLoaded', function() {
    const dropdownSelected = document.getElementById('dropdownSelected');
    const dropdownOptions = document.getElementById('dropdownOptions');
    const dropdownText = document.getElementById('dropdownText');

    // buka/tutup dropdown
    dropdownSelected.addEventListener('click', function() {
        const isOpen = dropdownOptions.style.display === 'block';
        dropdownOptions.style.display = isOpen ? 'none' : 'block';
        if (!isOpen) setTimeout(() => dropdownOptions.style.opacity = 1, 10);
        else dropdownOptions.style.opacity = 0;
    });

    // tutup dropdown kalau klik di luar
    document.addEventListener('click', function(e) {
        if (!dropdownSelected.contains(e.target) && !dropdownOptions.contains(e.target)) {
            dropdownOptions.style.display = 'none';
            dropdownOptions.style.opacity = 0;
        }
    });

    // update teks dropdown
    const updateSelectedText = () => {
        const checked = Array.from(dropdownOptions.querySelectorAll('input:checked'))
            .map(cb => cb.nextElementSibling.textContent.trim());

        if (checked.length === 0) {
            dropdownText.textContent = 'Pilih Kategori ...';
        } else if (checked.length <= 3) {
            dropdownText.textContent = checked.join(', ');
        } else {
            const firstThree = checked.slice(0, 3).join(', ');
            const remaining = checked.length - 3;
            dropdownText.innerHTML = `${firstThree} <span>+${remaining}</span>`;
        }
    };

    // update saat checkbox berubah
    dropdownOptions.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        cb.addEventListener('change', updateSelectedText);
    });

    // jalankan sekali di awal (kalau ada old data)
    updateSelectedText();
});
