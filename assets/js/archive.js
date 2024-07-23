// Coloca o nome do arquivo quando é anexado no formulário

document.getElementById('attachmentWord').addEventListener('change', function() {
    var label = document.getElementById('labelWord');
    var fileName = this.files[0].name;
    label.innerHTML = fileName;
});

document.getElementById('attachmentImg').addEventListener('change', function() {
    var label = document.getElementById('labelImg');
    var fileName = this.files[0].name;
    label.innerHTML = fileName;
});