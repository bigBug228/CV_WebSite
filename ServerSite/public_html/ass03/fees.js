const feeInfo = document.getElementById("fee-info");
const feeSelect = document.querySelector("form select[name='duration']");
const feeText = document.querySelector("form input[name='fee']");

var oReq = new XMLHttpRequest();

oReq.onload = function() {
    // This is where you handle what to do with the response.
    // The actual data is found on this.responseText
    if (this.responseText) {
        data = JSON.parse(this.responseText) // Will alert: 42
        console.log(data);
        feeSelect.addEventListener("change", function() {
            if (feeInfo) {
                console.log(data[0]);

                let price = 'No fee info';
                data.forEach(el => {
                    if (el['duration'] === feeSelect.value) {
                        console.log(el['price']);
                        price = el['price'];
                    }
                });

                feeInfo.innerText = price;
            }

            if (feeText) {
                let price = '';
                data.forEach(el => {
                    if (el['duration'] === feeSelect.value) {
                        console.log(el['price']);
                        price = el['price'];
                    }
                });

                feeText.value = price;
            }
        });
    } else {
        if (feeInfo) {
            feeInfo.innerText = "No fee info at the moment";
        }
    }
};
oReq.open("get", "get_fees_data.php", true);
oReq.send();