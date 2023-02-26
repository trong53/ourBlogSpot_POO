if (document.querySelector('.warning')!= undefined) {
    document.querySelector('#signIn').style.visibility = 'hidden';

    document.querySelector('.warning-close').onclick = function() {
        document.querySelector('.warning').classList.add('warning-hidden');
        document.querySelector('#signIn').style.visibility = 'visible';
    }     
}