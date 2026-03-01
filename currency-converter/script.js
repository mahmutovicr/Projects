const converterForm = document.getElementById("converter-form");
const fromCurrency = document.getElementById("from-currency");
const toCurrency = document.getElementById("to-currency");
const amountInput = document.getElementById("amount");
const resultDiv = document.getElementById("result");

window.addEventListener("load", fetchCurrencies);
converterForm.addEventListener("submit",convertCurrency);

async function fetchCurrencies() {
try {
const response = await fetch("https://api.exchangerate-api.com/v4/latest/USD");
const data = await response.json();
const currencyOptions = Object.keys(data.rates);
currencyOptions.forEach((currency) => {
const option1 = document.createElement("option");
option1.value = currency;
option1.textContent = currency;
fromCurrency.appendChild(option1);
const option2 = document.createElement("option");
option2.value = currency;
option2.textContent = currency;
toCurrency.appendChild(option2);
});
} catch (error) {
resultDiv.textContent = "Failed to load currencies. Please try again.";    
}
}

async function convertCurrency(e) {
e.preventDefault();
const amount = parseFloat(amountInput.value);
const fromCurrencyValue = fromCurrency.value;
const toCurrencyValue = toCurrency.value;
if (!amount || amount <= 0) {
alert("Please enter a valid amount");   
return;
}
resultDiv.textContent = "Converting...";                                
try {
const response = await fetch(`https://api.exchangerate-api.com/v4/latest/${fromCurrencyValue}`);
const data = await response.json();
const rate = data.rates[toCurrencyValue];
if (!rate) {                                                           
resultDiv.textContent = "Exchange rate not available.";             
return;                                                             
};      
const convertedAmount = (amount * rate).toFixed(2);
resultDiv.textContent = `${amount} ${fromCurrencyValue} = ${convertedAmount} ${toCurrencyValue}`;
} catch (error) {                                                       
    resultDiv.textContent = "Conversion failed. Please try again.";      
}                                                                        
}

































































