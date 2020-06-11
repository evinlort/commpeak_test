
const l = message => console.log(message);

const onClickEventListener = (event) => {
    let fetch = async () => {
        let fetch_data = () =>  window.fetch(
            window.config.baseUrl + "/customer_data/" + event.target.dataset.id,
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": window.config.csrf,
                    "Content-Type": "application/json"
                },
                body: event.target.dataset.customerData
            }
        )
        let result = await fetch_data()
        result.json().then(json => {
            let html = "<div> \
            <div>Number of all customer's calls: "+json.total_calls+": \
            </div> \
            <div>Total duration of all customer's calls: "+json.total_calls_duration+" seconds</div> \
            <div>Number of customer's calls within same continent: "+json.same_continent_total_calls+"</div> \
            <div>Total duration of customer's calls within same continent: "+json.same_continent_calls_duration+" seconds</div> \
            </div>"
            let next = event.target.nextElementSibling;
            next.innerHTML = html;
        })
    }
    fetch()
}

const customers = document.getElementsByClassName("customer");
for (var i = 0; i < customers.length; i++) {
    customers[i].addEventListener("click", onClickEventListener, false);
}
