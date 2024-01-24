function showDiv(number) {
    // Hide all divs
    var divs = document.getElementsByClassName('content-div');
    for (var i = 0; i < divs.length; i++) {
        divs[i].style.display = 'none';
    }

    // Show the selected div
    document.getElementById('div' + number).style.display = 'grid';
    document.getElementById('div' + number).style.gap = '3px';

}
