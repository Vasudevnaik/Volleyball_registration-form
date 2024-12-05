document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("volleyballForm");
    const responseDiv = document.getElementById("response");

    form.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent traditional form submission

        // Gather form data
        const formData = new FormData(form);

        // Display a success message (Simulated; for real usage, use AJAX)
        responseDiv.style.display = "block";
        responseDiv.innerHTML = `
            <h3>Registration Successful!</h3>
            <p>Thank you for registering for the volleyball team. Here are your details:</p>
            <ul>
                <li><strong>Name:</strong> ${formData.get("name")}</li>
                <li><strong>Email:</strong> ${formData.get("email")}</li>
                <li><strong>Phone:</strong> ${formData.get("phone")}</li>
                <li><strong>Date of Birth:</strong> ${formData.get("dob")}</li>
                <li><strong>Preferred Position:</strong> ${formData.get("position")}</li>
            </ul>
            <p><em>We will review your documents and get back to you shortly.</em></p>
        `;

        // Reset the form after submission
        form.reset();
    });
});
