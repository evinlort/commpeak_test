
const l = message => console.log(message);

const onClickEventListener = (event) => {
    alert(event.target.dataset.id)
}

const customers = document.getElementsByClassName("customer");
for(var i = 0; i < customers.length; i++) {
    customers[i].addEventListener("click", onClickEventListener, false);
}
