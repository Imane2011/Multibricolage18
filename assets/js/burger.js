// function toggleMenu() {
//     const menu = document.querySelector('.burger');
//     const burgerLogo = document.querySelector('.burgerLogo');
//     const burgerHiden = document.querySelector('.burgerHiden')
//     menu.classList.toggle('active');

//     if (menu.classList.contains('active')) {
//         burgerLogo.style.display = 'none'; 
//         burgerHiden.style.display = 'block'; 
//     } else {
//         burgerLogo.style.display = 'block'; 
//         burgerHiden.style.display = 'none'; 
//     }
// }


const burgerLogo = document.querySelector('.burgerLogo');
const burgerHiden = document.querySelector('.burgerHiden');


function toggleMenu() {
    const menu = document.querySelector('.burger');
    menu.classList.toggle('active');

    if (menu.classList.contains('active')) {
        burgerLogo.style.display = 'none';
        burgerHiden.style.display = 'block';
    } else {
        burgerLogo.style.display = 'block';
        burgerHiden.style.display = 'none';
    }
}


burgerLogo.addEventListener('click', toggleMenu);
burgerHiden.addEventListener('click', toggleMenu);