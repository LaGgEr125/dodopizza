 const acceptBtn = document.getElementById('accept-btn');
const rejectBtn = document.getElementById('reject-btn');
 const modal = document.getElementById("cookie-accept");
console.log("localStorage " + localStorage.getItem('usercookie'));
if(localStorage.getItem('usercookie')===null){
    modal.style.display="block";
}else {
     modal.style.display="hidden";
}
function handleCookieChoice(accepted) {
    console.log(`Пользователь ${accepted ? 'принял' : 'отклонил'} cookies`);
    
    // Сохраняем выбор в localStorage
    localStorage.setItem('usercookie', accepted);
    
    // Скрываем диалог
    modal.style.display = 'none';
    
}
acceptBtn.addEventListener('click', function() {
    handleCookieChoice(true);
});

rejectBtn.addEventListener('click', function() {
    handleCookieChoice(false);
});