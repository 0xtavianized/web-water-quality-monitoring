<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HISTORY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-3 dark:bg-neutral-800 sticky top-0 z-50">
        <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between">
            <div class="flex items-center justify-between">
                <a class="flex-none text-xl font-semibold dark:text-white focus:outline-none focus:opacity-80" href="#" aria-label="Brand">
                    MONITORING KUALITAS AIR
                </a>
                <div class="sm:hidden">
                    <button type="button" class="hs-collapse-toggle relative size-7 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" id="hs-navbar-example-collapse" aria-expanded="false" aria-controls="hs-navbar-example" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-example">
                        <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                        <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                </div>
            </div>
            <div id="hs-navbar-example" class="hidden hs-collapse overflow-hidden transition-all duration-300 basis-full grow sm:block" aria-labelledby="hs-navbar-example-collapse">
                <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
                    <a class="font-medium text-gray-600 hover:text-gray-400 focus:outline-none focus:text-gray-400 dark:text-neutral-400 dark:hover:text-neutral-500 dark:focus:text-neutral-500" href="/">Home</a>
                    <a class="font-medium text-blue-500 focus:outline-none" aria-current="page" href="/history">History</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        <div class="flex space-x-3 w-full">
            <div class="sm:flex sm:items-center w-1/2">
                <label for="startDate" class="block text-sm font-medium dark:text-white">Tanggal Awal : </label>
                <input type="date" id="startDate" class="max-w-xs py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
            </div>
            <div class="sm:flex sm:items-center w-1/2">
                <label for="endDate" class="block text-sm font-medium dark:text-white">Tanggal Akhir : </label>
                <input type="date" id="endDate" class="max-w-xs py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
            </div>
        </div>
        
        <!-- Button Section -->
        <div class="flex justify-center mt-5">
            <button id="filterButton" class="px-4 py-2 bg-blue-500 text-white rounded" onclick="pickDate()">Filter</button>
        </div>
    </div>     

    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No.</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Waktu</th>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">pH</th>
                                    <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Turbidity</th>
                                    <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">TDS</th>
                                </tr>
                            </thead>
                            <tbody id="thingSpeakTableBody" >
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="flex justify-center mt-4">
        <button id="previousButton" class="preline-btn preline-btn-outline text-gray-700 px-4 py-2 mr-2">Previous</button>
        <div id="pageNumbers" class="flex flex-wrap items-center space-x-2">
        </div>
        <button id="nextButton" class="preline-btn preline-btn-outline text-gray-700 px-4 py-2 ml-2">Next</button>
    </div> --}}
    <div class="flex flex-col items-center mt-4">
        <nav id="pagination" class="flex items-center gap-x-1" aria-label="Pagination"></nav>
    </div>
    

    <script>
        const itemsPerPage = 20;
        let currentPage = 1;
        let totalPages = 1;
        let allFeeds = [];
        let filteredFeeds = [];
        fetchThingSpeakData();

        async function pickDate() {
        const startDate = document.getElementById("startDate");
        const startDateValue = startDate.value;
        const endDate = document.getElementById("endDate");
        const endDateValue = endDate.value;

        console.log(startDateValue);
        console.log(endDateValue);

        let timeStart = "00:00:00";
        let timeEnd = "23:59:59";

        const url = `https://api.thingspeak.com/channels/2725512/feeds.json?api_key=HEWPZR8G2P58R4QR&start=${startDateValue}%20${timeStart}&end=${endDateValue}%20${timeEnd}&results=8000`;

        console.log("Fetching data from URL:", url);

            try {
                const response = await fetch(url);

                const data = await response.json();
                allFeeds = data.feeds;
                filteredFeeds = allFeeds;

                totalPages = Math.ceil(filteredFeeds.length / itemsPerPage);
                renderPage(currentPage);

                console.log("All Feeds:", allFeeds);
            } catch (error) {
                console.error("Error fetching data from ThingSpeak:", error);
            }
        }

        async function fetchThingSpeakData() {
            const url = `https://api.thingspeak.com/channels/2725512/feeds.json`;

            try {
                const response = await fetch(url);
                const data = await response.json();

                allFeeds = data.feeds;
                filteredFeeds = allFeeds;
                totalPages = Math.ceil(filteredFeeds.length / itemsPerPage);
                renderPage(currentPage);
                console.log(filteredFeeds.length);
            } catch (error) {
                console.error("Error fetching data from ThingSpeak:", error);
            }
        }
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); 
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');
                
            return `${day}-${month}-${year} / ${hours}:${minutes}:${seconds}`;
        }

        function renderPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageData = filteredFeeds.slice(start, end);
        
            let tableBody = '';
            pageData.forEach((feed, index) => {
                const formattedDate = formatDate(feed.created_at);
            
                tableBody += `
                    <tr>
                        <td class="px-6 py-3 text-start text-xs">${start + index + 1}</td>
                        <td class="px-6 py-3 text-start text-xs">${formattedDate}</td>
                        <td class="px-6 py-3 text-start text-xs">${feed.field1}</td>
                        <td class="px-6 py-3 text-end text-xs">${feed.field2}</td>
                        <td class="px-6 py-3 text-end text-xs">${feed.field3}</td>
                    </tr>
                `;
            });
        
            document.getElementById('thingSpeakTableBody').innerHTML = tableBody;
            updatePageNumbers();
        }

        function createButton(label, enabled, onClick) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = `min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 ${enabled ? '' : 'disabled:opacity-50 disabled:pointer-events-none'} dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10`;
            button.setAttribute('aria-label', label);
            if (!enabled) {
                button.disabled = true;
            }
            button.onclick = onClick;
            return button;
        }

        function updatePageNumbers() {
            const paginationNav = document.getElementById('pagination');
            if (!paginationNav) return;

            paginationNav.innerHTML = '';

            // Previous button
            const prevButton = createButton('Previous', currentPage > 1, () => renderPage(currentPage - 1));
            prevButton.innerHTML = ` 
                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
                <span class="sr-only">Previous</span>
            `;
            paginationNav.appendChild(prevButton);
            
            // Page numbers container
            const pageNumbersContainer = document.createElement('div');
            pageNumbersContainer.className = 'flex flex-wrap items-center gap-x-1';
            paginationNav.appendChild(pageNumbersContainer);
            
            const pageRange = getPageRange(currentPage, totalPages);
            
            pageRange.forEach((pageNum, index) => {
                if (pageNum === '...') {
                    const ellipsis = document.createElement('div');
                    ellipsis.className = 'hs-tooltip inline-block';
                    ellipsis.innerHTML = `
                        <button type="button" class="hs-tooltip-toggle group min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-400 hover:text-blue-600 p-2 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:bg-white/10">
                            <span class="group-hover:hidden text-xs">•••</span>
                            <svg class="group-hover:block hidden shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 17 5-5-5-5"></path>
                                <path d="m13 17 5-5-5-5"></path>
                            </svg>
                            <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700" role="tooltip">
                                Next pages
                            </span>
                        </button>
                    `;
                    pageNumbersContainer.appendChild(ellipsis);
                } else {
                    const pageButton = document.createElement('button');
                    pageButton.type = 'button';
                    pageButton.className = pageNum === currentPage
                        ? 'min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:focus:bg-white/10'
                        : 'min-h-[38px] min-w-[38px] flex justify-center items-center border border-transparent text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10';
                    pageButton.textContent = pageNum;
                    pageButton.onclick = () => renderPage(pageNum);
                    if (pageNum === currentPage) {
                        pageButton.setAttribute('aria-current', 'page');
                    }
                    pageNumbersContainer.appendChild(pageButton);
                }
            });
        
            // Next button
            const nextButton = createButton('Next', currentPage < totalPages, () => renderPage(currentPage + 1));
            nextButton.innerHTML = `
                <span class="sr-only">Next</span>
                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            `;
            paginationNav.appendChild(nextButton);
        }

        function getPageRange(currentPage, totalPages) {
            const range = [];
            const maxVisiblePages = 5; // Max number of pages to show
        
            if (totalPages <= maxVisiblePages) {
                for (let i = 1; i <= totalPages; i++) {
                    range.push(i);
                }
            } else {
                if (currentPage <= 3) {
                    for (let i = 1; i <= 3; i++) {
                        range.push(i);
                    }
                    range.push('...');
                    range.push(totalPages);
                } else if (currentPage >= totalPages - 2) {
                    range.push(1);
                    range.push('...');
                    for (let i = totalPages - 2; i <= totalPages; i++) {
                        range.push(i);
                    }
                } else {
                    range.push(1);
                    range.push('...');
                    range.push(currentPage - 1);
                    range.push(currentPage);
                    range.push(currentPage + 1);
                    range.push('...');
                    range.push(totalPages);
                }
            }
        
            return range;
        }


        function renderPage(page) {
            currentPage = page;
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageData = filteredFeeds.slice(start, end);
        
            let tableBody = '';
            pageData.forEach((feed, index) => {
                const formattedDate = formatDate(feed.created_at);
            
                tableBody += `
                    <tr>
                        <td class="px-6 py-3 text-start text-xs">${start + index + 1}</td>
                        <td class="px-6 py-3 text-start text-xs">${formattedDate}</td>
                        <td class="px-6 py-3 text-start text-xs">${feed.field1}</td>
                        <td class="px-6 py-3 text-end text-xs">${feed.field2}</td>
                        <td class="px-6 py-3 text-end text-xs">${feed.field3}</td>
                    </tr>
                `;
            });
        
            document.getElementById('thingSpeakTableBody').innerHTML = tableBody;
            updatePageNumbers();
        }

        function applyDateFilter() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            if (startDate && endDate) {
                filteredFeeds = allFeeds.filter(feed => {
                    const feedDate = new Date(feed.created_at);
                    return feedDate >= new Date(startDate) && feedDate <= new Date(endDate);
                });
            } else {
                filteredFeeds = allFeeds; 
            }

            totalPages = Math.ceil(filteredFeeds.length / itemsPerPage);
            renderPage(1); 
        }

        document.getElementById('filterButton').addEventListener('click', applyDateFilter);

        document.getElementById('previousButton').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderPage(currentPage);
            }
        });

        document.getElementById('nextButton').addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderPage(currentPage);
            }
        });

        
    </script>
</body>
</html>
