const discount = document.querySelector("#discount")
const carSelect = document.querySelector("#car")
const customerSelect = document.querySelector("#customer")
const calculateBtn = document.querySelector("#calculate")
const outputMsgBox = document.querySelector(".output-msg")

let carSelectOptions = '<option value="0" disabled selected>-- Wybierz produkt --</option>'
let customerSelectOptions = '<option value="0" disabled selected>-- Wybierz klienta --</option>'


// Cena netto -> brutto
const calcVAT = price => {
    return (price*1.23).toFixed(2)
}

// Cena brutto -> netto
const calcNet = price => {
    return (price/1.23).toFixed(2)
}

const finalPrice = (product, discount) => {
    return product.netPrice - (product.netPrice * (discount/100))
}

const checkCustomer = e => {
    const customer = customers[e.target.value - 1]
    const error = e.target.nextElementSibling

    if (customer.purchases > 2) {
        customer.isPatron = true
    }

    if (customer.isPatron) {
        error.classList.remove('hide')
        error.textContent = 'Rabat stałego klienta (5%)'
    }
    else {
        error.classList.add('hide')
        error.textContent = ''
    }
}

const checkFields = () => {
    let fieldsOk = true

    if (discount.value == '') { discount.value = 0 }
    if (customerSelect.value == 0) { fieldsOk = false }
    if (carSelect.value == 0) { fieldsOk = false }

    return fieldsOk
}

const outputMsg = e => {
    e.preventDefault()

    if (!checkFields()) return

    const customer = customers[customerSelect.value - 1]
    const car = cars[carSelect.value - 1]
    let carDiscount = Math.abs(parseInt(discount.value))

    if (customer.isPatron) {
        carDiscount += 5
    }

    const priceTax = calcVAT(car.netPrice) - car.netPrice
    const price = finalPrice(car, carDiscount)
    
    outputMsgBox.innerHTML = `<h3>${car.brand} ${car.model}</h3><br>Cena netto ${carDiscount > 0 ? `(-${carDiscount}%)` : ''}: ${price} PLN<br>VAT: ${priceTax} PLN<br>Razem: ${price + priceTax} PLN`
}


cars.forEach(car => {
    carSelectOptions += `<option value='${car.id}'>${car.brand} ${car.model}</option>`
})

customers.forEach(customer => {
    customerSelectOptions += `<option value='${customer.id}'>${customer.fullName}</option>`
})

carSelect.innerHTML = carSelectOptions
customerSelect.innerHTML = customerSelectOptions

calculateBtn.addEventListener('click', outputMsg)
customerSelect.addEventListener('change', checkCustomer)