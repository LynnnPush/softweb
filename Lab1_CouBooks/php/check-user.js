const emailInput = document.getElementById("email");
const step1_btn = document.getElementById("step1_btn");
const welcomeMsg = document.getElementById("welcomeMsg");

// the default state is 'disabled'
step1_btn.disabled = true;

// Every time the key of the keyboard is fully released, the buttonState function is called
emailInput.addEventListener("keyup", buttonState);

function buttonState() {
    step1_btn.disabled = emailInput.value === "";
}

// When the button is clicked, do a POST request
step1_btn.addEventListener("click", async () => {
    // Clear any previous message
    welcomeMsg.innerHTML = "";

    const userEmail = emailInput.value.trim();
    console.log("User email: ", userEmail);

    if (!userEmail) {
        welcomeMsg.innerHTML = `<p style="color: red;">Please enter a valid email.</p>`;
        return;
    }

    try {
        // a. Send POST request with JSON body
        const response = await fetch("http://localhost/check_user.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ email: userEmail }),
        });

        // b. Check if response is okay (2xx status)
        if (!response.ok) {
            // If not 2xx, parse the error if possible
            const errorData = await response.json();
            throw new Error(errorData.message || `Status code: ${response.status}`);
        }

        // 4c. Parse JSON
        const data = await response.json();
        console.log("Server response:", data);

        // 4d. If success, show the welcome message
        if (data.status === "success") {
            welcomeMsg.innerHTML = `<p style="color: green;">${data.message}</p>`;
            // Optionally, redirect to another page or enable next steps:
            // window.location.href = "someOtherPage.php";
        } else {
            // Show an error message
            welcomeMsg.innerHTML = `<p style="color: red;">${data.message}</p>`;
        }
    } catch (error) {
        console.error("Fetch error:", error);
        welcomeMsg.innerHTML = `<p style="color: red;">Error: ${error.message}</p>`;
    }
});