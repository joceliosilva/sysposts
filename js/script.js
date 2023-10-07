// Função para exibir o toast
function showToast(message) {
    var toast = document.getElementById("toast");
    toast.textContent = message;
    toast.classList.remove("hidden");
    setTimeout(function() {
        toast.classList.add("hidden");
    }, 3000); // Oculta o toast após 3 segundos (ajuste conforme necessário)
}


document.querySelectorAll('.ver-mais').forEach(function(button) {
    button.addEventListener('click', function() {
        var postId = button.getAttribute('data-postid');
        var postExcerpt = document.querySelector('.post-excerpt[data-postid="' + postId + '"]');
        var postContent = postContents[postId];

        postExcerpt.innerHTML = postContent;
        button.style.display = 'none';
    });
});
