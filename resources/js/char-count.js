export function charCount() {
    const textarea = document.getElementById("details");
    const charCount = document.getElementById("char-count");

    if (!textarea || !charCount) return;

    function updateCharCount() {
        const count = textarea.value.length;
        charCount.textContent = count;
    }

    textarea.addEventListener("input", updateCharCount);
    updateCharCount();
}
