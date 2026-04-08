<!-- LIVE CHAT WIDGET -->
<script src="https://unpkg.com/lucide@latest"></script>
<div class="fixed bottom-6 right-6 z-50">
    <!-- Chat Button -->
    <button onclick="toggleChat()" id="chatWidgetBtn" class="w-14 h-14 bg-blue-600 rounded-full shadow-[0_0_20px_rgba(37,99,235,0.4)] flex items-center justify-center text-white hover:bg-blue-700 hover:scale-105 transition-all duration-300 relative group">
        <i data-lucide="message-circle" class="w-7 h-7"></i>
        <!-- Ping dot for new messages could be here -->
        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full border-2 border-gray-950 hidden" id="chatUnreadDot"></span>
    </button>

    <!-- Chat Window -->
    <div id="chatWidgetWindow" class="hidden absolute bottom-20 right-0 w-[350px] h-[500px] bg-gray-900 border border-gray-700 rounded-2xl shadow-2xl flex flex-col overflow-hidden origin-bottom-right transition-all transform scale-100">
        
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-4 flex justify-between items-center shadow-md z-10 relative overflow-hidden">
            <div class="absolute inset-0 bg-white/10 opacity-50"></div>
            <div class="flex items-center gap-3 relative">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white backdrop-blur-sm">
                    <i data-lucide="headphones" class="w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm">Customer Support</h4>
                    <p class="text-blue-100 text-[10px] uppercase tracking-widest font-bold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span> Online
                    </p>
                </div>
            </div>
            <button onclick="toggleChat()" class="text-white hover:bg-white/20 w-8 h-8 rounded-full flex items-center justify-center transition relative">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="chatWidgetMessages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-[#0a0a0a] bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjMGEwYTBhIj48L3JlY3Q+CjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiMxYTFhMWEiPjwvcmVjdD4KPC9zdmc+')] shadow-inner">
            <div class="text-center">
                <p class="text-[10px] uppercase font-bold tracking-widest text-gray-500 bg-gray-900 inline-block px-3 py-1 rounded-full border border-gray-800">Hari Ini</p>
            </div>
            
            <div class="flex justify-start">
                <div class="bg-gray-800 border border-gray-700 text-gray-200 p-4 rounded-2xl rounded-tl-sm max-w-[85%] shadow-lg">
                    <p class="text-xs leading-relaxed">Halo! 👋 Ada yang bisa kami bantu mengenai pesanan atau produk di TFD?</p>
                </div>
            </div>
            
            <!-- Dynamic Messages -->
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-gray-900 border-t border-gray-800 relative z-10">
            <form onsubmit="sendUserMessage(event)" class="flex gap-2">
                <input type="text" id="userMessageInput" required placeholder="Tulis keluhan Anda..." class="flex-1 bg-black border border-gray-700 rounded-xl px-4 text-xs text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition shadow-inner">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 w-10 h-10 rounded-xl flex items-center justify-center text-white transition shadow-lg shrink-0">
                    <i data-lucide="send" class="w-4 h-4 ml-1"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let chatWidgetOpen = false;
    let chatUserPoll;
    
    function toggleChat() {
        chatWidgetOpen = !chatWidgetOpen;
        const windowEl = document.getElementById('chatWidgetWindow');
        
        if(chatWidgetOpen) {
            windowEl.classList.remove('hidden');
            fetchUserMessages();
            chatUserPoll = setInterval(fetchUserMessages, 3000);
            
            // Initial check for lucide icons inside chat if not loaded
            if (typeof lucide !== 'undefined') lucide.createIcons();
            
            // Scroll to bottom
            const chatBox = document.getElementById('chatWidgetMessages');
            chatBox.scrollTop = chatBox.scrollHeight;
        } else {
            windowEl.classList.add('hidden');
            if(chatUserPoll) clearInterval(chatUserPoll);
        }
    }

    function fetchUserMessages() {
        // Cek auth, asumsi jika ada user login, cookie/session ada. TFD membatasi fitur untuk auth user.
        fetch('/chat/messages')
            .then(res => {
                if(!res.ok) throw new Error("Not authenticated");
                return res.json();
            })
            .then(data => {
                const chatBox = document.getElementById('chatWidgetMessages');
                
                // Cek scroll bottom info
                const isBottom = chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < 50;
                
                if (data.chats && data.chats.length > 0) {
                    let htmlContent = `
                        <div class="text-center">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-gray-500 bg-gray-900 inline-block px-3 py-1 rounded-full border border-gray-800">Hari Ini</p>
                        </div>
                        <div class="flex justify-start">
                            <div class="bg-gray-800 border border-gray-700 text-gray-200 p-4 rounded-2xl rounded-tl-sm max-w-[85%] shadow-lg">
                                <p class="text-xs leading-relaxed">Halo! 👋 Ada yang bisa kami bantu mengenai pesanan atau produk di TFD?</p>
                            </div>
                        </div>
                    `;
                    
                    data.chats.forEach(chat => {
                        const timeObj = new Date(chat.created_at);
                        const time = timeObj.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
                        if (!chat.is_admin) {
                            htmlContent += `
                                <div class="flex justify-end">
                                    <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-sm max-w-[85%] shadow-lg">
                                        <p class="text-xs leading-relaxed">${chat.message}</p>
                                        <p class="text-[9px] text-blue-200 mt-1.5 text-right opacity-70">${time}</p>
                                    </div>
                                </div>
                            `;
                        } else {
                            htmlContent += `
                                <div class="flex justify-start">
                                    <div class="bg-gray-800 border border-gray-700 text-gray-200 p-3 rounded-2xl rounded-tl-sm max-w-[85%] shadow-lg">
                                        <p class="text-xs leading-relaxed">${chat.message}</p>
                                        <p class="text-[9px] text-gray-500 mt-1.5">${time}</p>
                                    </div>
                                </div>
                            `;
                        }
                    });
                    chatBox.innerHTML = htmlContent;
                }

                if(isBottom) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            })
            .catch(err => {
                console.log("Chat fetch suppressed / user not logged in");
            });
    }

    function sendUserMessage(e) {
        e.preventDefault();
        const msgInput = document.getElementById('userMessageInput');
        const msg = msgInput.value;
        if(!msg.trim()) return;

        msgInput.value = '';
        const csrfToken = "{{ csrf_token() }}";

        // Optimistic
        const chatBox = document.getElementById('chatWidgetMessages');
        chatBox.innerHTML += `
            <div class="flex justify-end opacity-50">
                <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-sm max-w-[85%] shadow-lg">
                    <p class="text-xs leading-relaxed">${msg}</p>
                    <p class="text-[9px] text-blue-200 mt-1.5 text-right opacity-70">Mengirim...</p>
                </div>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
            fetchUserMessages();
        })
        .catch(err => console.error(err));
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
