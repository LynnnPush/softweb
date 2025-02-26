// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", () => {

    // Select all elements that have a data-isbn attribute
    const isbnElements = document.querySelectorAll('[data-isbn]');

// Loop over each element and add a click listener
    isbnElements.forEach((element) => {
        element.addEventListener("click", async (event) => {
            const isbn = event.currentTarget.dataset.isbn;

            // Optional: display a loading message (make sure you have a container for the result)
            const bookInfoContainer = document.getElementById("book-info");
            if (bookInfoContainer) {
                bookInfoContainer.innerHTML = "Loading...";
            }

            try {
                const response = await fetch(`https://openlibrary.org/isbn/${isbn}.json`);
                if (!response.ok) {
                    throw new Error(`Network response was not ok (status: ${response.status})`);
                }

                const bookData = await response.json();
                const title = bookData.title || "No title available";
                const publishDate = bookData.publish_date || "No publish date available";
                const pageCount = bookData.number_of_pages || "Unknown page count";

                bookInfoContainer.innerHTML = `
        <p><strong>Title:</strong> ${title}</p>
        <p><strong>Publish Date:</strong> ${publishDate}</p>
        <p><strong>Number of Pages:</strong> ${pageCount}</p>
      `;
            } catch (error) {
                console.error("Fetch error:", error);
                bookInfoContainer.innerHTML = `<p style="color: red;">Error: Could not fetch book data.</p>`;
            }
        });
    });
});
