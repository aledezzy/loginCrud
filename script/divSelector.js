function showDiv(number) {

    var divs = document.getElementsByClassName('content-div');
    for (var i = 0; i < divs.length; i++) {
        divs[i].style.display = 'none';
    }


    document.getElementById('div' + number).style.display = 'grid';
    //document.getElementById('div' + number).style.gap = '3px';

}
