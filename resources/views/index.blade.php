<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MONITORING</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="flex flex-wrap h-20 sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-3 dark:bg-neutral-900 sticky top-0 z-50">
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
                <div class="flex flex-col gap-5 mt-5 items-end sm:flex-row sm:items-center sm:mt-0 sm:justify-end sm:ps-5">
                    <a class="font-medium text-blue-500 focus:outline-none dark:text-white" href="{{ url('/') }}" aria-current="page">Home</a>
                    <a class="font-medium text-gray-600 hover:text-gray-400 focus:outline-none focus:text-gray-400 dark:text-neutral-500 dark:hover:text-white dark:focus:text-neutral-500" href="{{ url('/history') }}">History</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Loading spinner -->
    <div class="fixed inset-0 flex items-center justify-center z-50 dark:bg-neutral-800" id="loading">
      <div class="animate-spin inline-block size-16 border-[6px] border-current border-t-transparent text-blue-600 rounded-full dark:text-white" role="status" aria-label="loading">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <div class="w-full h-screen flex justify-center items-center flex-col text-center dark:bg-neutral-800" id="data-container">
        <div class="flex flex-col mb-5 bg-white border-2 border-black shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" id="ph">
        </div>

        <div class="flex flex-col mb-5 bg-white border-2 border-black shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" id="turbidity">
        </div>

        <div class="flex flex-col mb-5 bg-white border-2 border-black shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" id="tds">
        </div>

        <div class="mt-10 text-4xl font-bold dark:text-white" id="status">
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {        
            const apiUrl = "https://api.thingspeak.com/channels/2725512/feeds.json?results=1";
            const loadingElement = document.getElementById("loading");
            const dataContainer = document.getElementById("data-container");

            function getStatus(value, type) {
                value = parseFloat(value);
            
                switch (type) {
                    case 'ph':
                        if (value >= 6.5 && value <= 8.5) return { color: 'text-green-500', description: 'Normal', level: 'normal' };
                        else if (value < 6.5 ) return { color: 'text-red-500', description: 'Air Asam', level: 'danger' };
                        else if (value > 8.5) return { color: 'text-red-500', description: 'Air Basa', level: 'danger' };
                    case 'turbidity':
                        if (value < 25) return { color: 'text-green-500', description: 'Normal', level: 'normal' };
                        else if (value < 35) return { color: 'text-yellow-500', description: 'Agak Keruh', level: 'warning' };
                        else return { color: 'text-yellow-500', description: 'Sangat Keruh', level: 'warning' };
                    case 'tds':
                        if (value <= 300) return { color: 'text-green-500', description: 'Normal', level: 'normal' };
                        else if (value < 500) return { color: 'text-red-500', description: 'Agak Konduktif', level: 'danger' };
                        else return { color: 'text-red-500', description: 'Sangat Konduktif', level: 'danger' };
                    default:
                        return { color: 'text-gray-500', description: 'Data tidak valid!', level: 'unknown' };
                }
            }

            function calculateOverallStatus(statuses) {
                const levels = statuses.map(status => status.level);
            
                const dangerCount = levels.filter(level => level === 'danger').length;
                const warningCount = levels.filter(level => level === 'warning').length;
                const normalCount = levels.filter(level => level === 'normal').length;
            
                if (dangerCount >= 1 && warningCount >= 1) return { text: 'Bahaya', color: 'text-red-500' };
                if (dangerCount >= 1 && normalCount >= 1) return { text: 'Warning', color: 'text-yellow-500' };
                if (warningCount >= 2) return { text: 'Warning', color: 'text-yellow-500' };
                if (warningCount === 1 && normalCount >= 2) return { text: 'Normal', color: 'text-green-500' };
            
                return { text: 'Normal', color: 'text-green-500' };
            }

            async function fetchData() {
                try {
                    loadingElement.classList.remove("hidden");
                    dataContainer.classList.add("hidden");
                
                    const response = await fetch(apiUrl);
                    const data = await response.json();
                
                    const ph = data.feeds[0]?.field1 || "N/A";
                    const turbidity = data.feeds[0]?.field2 || "N/A";
                    const tds = data.feeds[0]?.field3 || "N/A";
                
                    const phStatus = getStatus(ph, 'ph');
                    const turbidityStatus = getStatus(turbidity, 'turbidity');
                    const tdsStatus = getStatus(tds, 'tds');
                
                    const overallStatus = calculateOverallStatus([phStatus, turbidityStatus, tdsStatus]);
                
                    document.getElementById("ph").innerHTML = `
                        <div class="text-4xl mb-1 font-bold ${phStatus.color}">
                            pH (Keasaman): ${ph}
                            <span class="text-xl mt-2 block">${phStatus.description}</span>
                        </div>
                    `;
                    
                    document.getElementById("turbidity").innerHTML = `
                        <div class="text-4xl mb-1 font-bold ${turbidityStatus.color}">
                            Kekeruhan: ${turbidity} NTU
                            <span class="text-xl mt-2 block">${turbidityStatus.description}</span>
                        </div>
                    `;
                    
                    document.getElementById("tds").innerHTML = `
                        <div class="text-4xl mb-1 font-bold ${tdsStatus.color}">
                            Konduktifitas: ${tds} ppm
                            <span class="text-xl mt-2 block">${tdsStatus.description}</span>
                        </div>
                    `;
                    
                    document.getElementById("status").innerHTML = `
                        Status: <span class="${overallStatus.color}">${overallStatus.text}</span>
                    `;
                    
                } catch (error) {
                    console.error("Error fetching data:", error);
                    dataContainer.innerHTML = `<p class="text-red-500">Error fetching data. Please try again later.</p>`;
                } finally {
                    loadingElement.classList.add("hidden");
                    dataContainer.classList.remove("hidden");
                }
            }

            setInterval(fetchData, 15000);
            fetchData();
        });
    </script>
</body>
</html>