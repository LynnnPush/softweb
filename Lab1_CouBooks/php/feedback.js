const authorInput = document.getElementById("author");
const feedbackInput = document.getElementById("feedback");
const submitBtn = document.getElementById("submit");

// the default state is 'disabled'
submitBtn.disabled = true;

// Every time the key of the keyboard is fully released, the buttonState function is called
authorInput.addEventListener("keyup", buttonState);
feedbackInput.addEventListener("keyup", buttonState);

function buttonState() {
    if (authorInput.value === "" || feedbackInput.value === "") {
        submitBtn.disabled = true; // return disabled as true whenever the input field is empty
    } else {
        submitBtn.disabled = false; // enable the button once the input field has content
    }
}

// just verifying that the button has been clicked
submitBtn.addEventListener("click", () => {
    console.log("Feedback submitted - Author:", authorInput.value, "Feedback:", feedbackInput.value);
});