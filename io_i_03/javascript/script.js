const koszyk = document.querySelector('#wartosc-koszyka')
const waga = document.querySelector('#waga-przesylki')
const wielkoscPrzesylkiRadio = document.querySelector('.input__box--radio')
const calcBtn = document.querySelector('#calculate')
const output = document.querySelector('.output-msg')
// Wielkosci przesylki
const przesylkaMala = document.querySelector('#przesylka-mala')
const przesylkaSrednia = document.querySelector('#przesylka-srednia')
const przesylkaDuza = document.querySelector('#przesylka-duza')
// Przesylka niestandardowa
const przesylkaNiestandardowa = document.querySelector('#przesylka-niestandardowa')
const cenaNiestandardowaBox = document.querySelector('.cena-niestandardowa')
const przesylkaNiestandardowaInput = document.querySelector('#przesylka-niestandardowa-cena')
//Ceny przesylki
const przesylkaMalaCena = 24
const przesylkaSredniaCena = 26
const przesylkaDuzaCena = 28


const sprawdzPola = () => {
    let ok = true

    if (koszyk.value == '') {
        ok = false
        koszyk.nextElementSibling.textContent = 'Podaj wartość koszyka!'
        koszyk.nextElementSibling.classList.remove('hide')
    }
    else if (waga.value == '') {
        ok = false
        waga.nextElementSibling.textContent = 'Podaj wagę!'
        waga.nextElementSibling.classList.remove('hide')
    }

    return ok
}


const errorReset = () => {
    const error = document.querySelectorAll('.error')
    error.forEach(element => {
        element.classList.add('hide')
        element.textContent = ''
    });
}


const czyGratis = () => {
    const error = koszyk.nextElementSibling
    const wartoscKoszyka = parseInt(koszyk.value)

    if (wartoscKoszyka >= 500) {
        error.classList.remove('hide')
        error.textContent = 'Dostawa gratis'
    }
    else {
        error.classList.add('hide')
        error.textContent = ''
    }
}


const sugerowanaCena = () => {
    const error = przesylkaNiestandardowaInput.nextElementSibling
    const wagaPrzesylki = parseInt(waga.value)

    if (wagaPrzesylki >= 5) {
        error.classList.remove('hide')
        error.textContent = `Sugerowana cena: ${28 + wagaPrzesylki} zł`
    }
    else {
        error.classList.add('hide')
        error.textContent = ''
    }
}


const czyNiestandardowa = () => {
    if (przesylkaNiestandardowa.checked) {
        cenaNiestandardowaBox.classList.remove('hide')
        sugerowanaCena()
        return true
    }
    else {
        cenaNiestandardowaBox.classList.add('hide')
        return false
    }
}


const rozmiarPrzesylki = () => {
    const niestandardowa = czyNiestandardowa()
    const wartoscKoszyka = parseInt(koszyk.value)

    if (wartoscKoszyka >= 500) {
        return 0
    }

    if (niestandardowa) {
        const input = parseInt(przesylkaNiestandardowaInput.value)
        if (input == '') {
            input = 0
        }
        return Math.abs(input)
    }
    else if (przesylkaMala.checked) {
        return przesylkaMalaCena
    }
    else if (przesylkaSrednia.checked) {
        return przesylkaSredniaCena
    }
    else if (przesylkaDuza.checked) {
        return przesylkaDuzaCena
    }
    else {
        console.error('Nie można zwrócić rozmiaru przesylki!')
    }
}


const obliczCene = e => {
    e.preventDefault()

    if (!sprawdzPola()) return
    else errorReset()

    const wartoscKoszyka = parseInt(koszyk.value)
    const cenaDostawy = rozmiarPrzesylki()

    output.innerHTML = `Dostawa: ${cenaDostawy} zł<br>Łącznie: ${wartoscKoszyka + cenaDostawy} zł`
}


waga.addEventListener('keyup', sugerowanaCena)
koszyk.addEventListener('keyup', czyGratis)
wielkoscPrzesylkiRadio.addEventListener('change', rozmiarPrzesylki)
calcBtn.addEventListener('click', obliczCene)