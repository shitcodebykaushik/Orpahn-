const chatToggle = document.getElementById("chatToggle");
const chatPanel = document.getElementById("chatPanel");
const chatClose = document.getElementById("chatClose");
const chatForm = document.getElementById("chatForm");
const chatInput = document.getElementById("chatInput");
const chatMessages = document.getElementById("chatMessages");

function appendMessage(text, type) {
    const item = document.createElement("div");
    item.className = `chat-message ${type}`;
    item.textContent = text;
    chatMessages.appendChild(item);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function toggleChat(open) {
    const shouldOpen = open ?? !chatPanel.classList.contains("active");
    chatPanel.classList.toggle("active", shouldOpen);
}

if (chatToggle && chatPanel && chatClose && chatForm) {
    chatToggle.addEventListener("click", () => toggleChat(true));
    chatClose.addEventListener("click", () => toggleChat(false));

    chatForm.addEventListener("submit", async (event) => {
        event.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        appendMessage(message, "user");
        chatInput.value = "";
        appendMessage("Thinking...", "bot pending");

        try {
            const response = await fetch("chat-api.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ message })
            });
            const data = await response.json();
            chatMessages.querySelector(".chat-message.bot.pending")?.remove();
            if (data.reply) {
                appendMessage(data.reply, "bot");
            } else {
                appendMessage("Sorry, I could not respond right now.", "bot");
            }
        } catch (error) {
            chatMessages.querySelector(".chat-message.bot.pending")?.remove();
            appendMessage("Sorry, I could not respond right now.", "bot");
        }
    });
}
