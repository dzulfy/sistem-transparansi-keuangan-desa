    </div>
</main>
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Format Rupiah Input
    document.addEventListener("DOMContentLoaded", function() {
        const rupiahInputs = document.querySelectorAll('input[name="jumlah_anggaran"], input[name="jumlah_realisasi"]');
        rupiahInputs.forEach(input => {
            // Force type to text so we can display dots
            input.type = 'text';
            
            // Format existing value on load
            if (input.value) {
                formatRupiahInput(input);
            }

            // Format on input event
            input.addEventListener('input', function() {
                formatRupiahInput(this);
            });
        });
    });

    function formatRupiahInput(input) {
        let cursorPosition = input.selectionStart;
        let originalLength = input.value.length;
        
        let value = input.value.replace(/\D/g, "");
        if (value === "") {
            input.value = "";
            return;
        }
        
        let formatted = new Intl.NumberFormat('id-ID').format(value);
        input.value = formatted;

        // Adjust cursor position to handle added/removed dots
        let newLength = formatted.length;
        let diff = newLength - originalLength;
        let newCursorPosition = cursorPosition + diff;
        
        newCursorPosition = Math.max(0, Math.min(newCursorPosition, newLength));
        input.setSelectionRange(newCursorPosition, newCursorPosition);
    }
</script>
</body>
</html>
