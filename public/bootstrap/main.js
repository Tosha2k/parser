$(document).ready(function() {
    $('.movie-name').on('click', function () {
        const parentTr = $(this).parent().parent();
        const name = parentTr.find('.name').text();
        const voices = parentTr.find('.voices').text();
        const estimatedScore = parentTr.find('.estimatedScore').text();
        const averageScore = parentTr.find('.averageScore').text();
        const shortDesc = parentTr.find('.shortDesc').text();


        $('#modal-name').text(name);
        $('#modal-estimated').text('Расчетный балл: ' + estimatedScore);
        $('#modal-average').text('Средний балл: ' + averageScore);

        $('#modal-voices').text('Голоса: ' + voices);
        $('#modal-desc').text(shortDesc);

        $('#modalDesc').modal();
        return false
    });
});