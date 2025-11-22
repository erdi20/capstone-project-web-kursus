<x-app-layout>

    <div class="max-w-6xl mx-auto px-4">
        <div class="pb-4 mb-6 page-container bg-white shadow-xl">
            <div class="pt-8 px-4 pb-6 sm:px-6 mt-6 mb-6">
                <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Quiz Assignment</h1>
                {{-- <p class="text-gray-700 mb-4 mx-3">Please answer the following questions:</p> --}}
                <form action="{{ Route('course.submitQuiz') }}" method="POST">
                    <div class="my-4 mx-4 py-5 px-5 bg-blue-400 rounded-2xl">
                        @csrf

                        <div class="text-gray-800 font-semibold mb-4 flex justify-between items-center">
                            <p class=" m-2 ml-5 mb-3 p-2 px-6 text-2xl">Ga ngerti iki nko bakal e diisi opo</p>
                            <p class=" m-2 mr-8 mb-3 p-2 px-6">
                                Time: <span id="time" class="font-bold"></span>
                            </p>
                        </div>

                        <div class="mb-5 mx-12 h-3 w-auto border-b-4 border-t-2 border-slate-700"></div>

                        <div class="mb-6">
                            <fieldset>
                                <div id="pilihanGanda">
                                    <!-- Quiz questions will be injected here by JavaScript -->
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div id="buttons" class=" py-6 grid grid-cols-2 gap-4 justify-items-center">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var quiz = [{
                "id": 1,
                "pertanyaan": "Berapa waktu kompleksitas untuk mencari elemen di dalam Binary Search Tree yang seimbang?",
                "pilihan": [{
                        "label": "A",
                        "teks": "O(n)"
                    },
                    {
                        "label": "B",
                        "teks": "O(log n)"
                    },
                    {
                        "label": "C",
                        "teks": "O(n²)"
                    },
                    {
                        "label": "D",
                        "teks": "O(1)"
                    }
                ],
                "jawaban_benar": "B",
                "penjelasan": "Dalam Binary Search Tree yang seimbang, waktu pencarian adalah O(log n) karena setiap perbandingan mengeliminasi setengah dari sisa elemen."
            },
            {
                "id": 2,
                "pertanyaan": "Algoritma mana yang menggunakan prinsip 'Divide and Conquer'?",
                "pilihan": [{
                        "label": "A",
                        "teks": "Linear Search"
                    },
                    {
                        "label": "B",
                        "teks": "Bubble Sort"
                    },
                    {
                        "label": "C",
                        "teks": "Merge Sort"
                    },
                    {
                        "label": "D",
                        "teks": "Insertion Sort"
                    }
                ],
                "jawaban_benar": "C",
                "penjelasan": "Merge Sort membagi array menjadi bagian-bagian kecil (divide), mengurutnya, kemudian menggabungkannya kembali (conquer)."
            },
            {
                "id": 3,
                "pertanyaan": "Struktur data apa yang cocok untuk implementasi cache dengan kebijakan LRU (Least Recently Used)?",
                "pilihan": [{
                        "label": "A",
                        "teks": "Hash Map + Doubly Linked List"
                    },
                    {
                        "label": "B",
                        "teks": "Array saja"
                    },
                    {
                        "label": "C",
                        "teks": "Single Linked List"
                    },
                    {
                        "label": "D",
                        "teks": "Queue biasa"
                    }
                ],
                "jawaban_benar": "A",
                "penjelasan": "Hash Map memberikan akses O(1) ke elemen, dan Doubly Linked List memungkinkan pemindahan elemen ke depan untuk tracking penggunaan terbaru dengan mudah."
            }
        ]

        function loadQuiz() {
            pilihanGanda = document.getElementById('pilihanGanda')
            teksQuiz = ""

            quiz.forEach(el => {
                teksQuiz += `<div class="px-4 py-4 flex">
                                            <div class="flex-shrink-0 w-4">
                                                <h1 class="text-xl font-extrabold">${el.id}.</h1>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div
                                                    class="block text-gray-800 font-semibold py-4 px-4 mb-3 mx-2 rounded-xl bg-slate-300">
                                                    ${el.pertanyaan}
                                                </div>
                                                
                                                <div class="flex flex-col sm:grid sm:grid-cols-2 gap-2 gap-x-16">`

                el.pilihan.forEach(pil => {
                    teksQuiz += `<label
                                                        class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-300">
                                                        <input type="radio" name="question${el.id}" value="${pil.teks}"
                                                            class="form-radio h-4 w-4 text-blue-600" >
                                                        <span class="text-gray-700">${pil.teks}</span>
                                                    </label>`
                })
                teksQuiz += `
                                                </div>
                                            </div>
                                        </div>`
            });

            pilihanGanda.innerHTML = teksQuiz

        }

        submitButton = () => {
            buttons = document.getElementById('buttons')

            button = `
                        <div>
                            <h1><button class="p-3 px-6 rounded-xl bg-blue-400 font-black">Back</button></h1>
                        </div>
                        <div>
                            <button type="submit" class="p-3 px-6 rounded-xl bg-blue-400 font-black">Kirim Quiz</button>
                        </div>`

            buttons.innerHTML = button
        }

        // fungsi hitung waktu
        function hitungWaktu() {
            const timeEl = document.getElementById('time');
            if (!timeEl) return;

            const start = Date.now();
            timeEl.textContent = '00:00';

            const intervalId = setInterval(() => {
                const elapsedSec = Math.floor((Date.now() - start) / 1000);

                timeEl.innerHTML = format(elapsedSec);
            }, 1000);

            // const form = document.querySelector('form');
            // if (form) {
            //     form.addEventListener('submit', () => {
            //         clearInterval(intervalId);
            //         const totalSeconds = Math.floor((Date.now() - start) / 1000);
            //         let hidden = document.querySelector('input[name="elapsed_seconds"]');
            //         if (!hidden) {
            //             hidden = document.createElement('input');
            //             hidden.type = 'hidden';
            //             hidden.name = 'elapsed_seconds';
            //             form.appendChild(hidden);
            //         }
            //         hidden.value = totalSeconds;
            //     });
            // }

            function format(s) {
                const mm = String(Math.floor(s / 60)).padStart(2, '0');
                const ss = String(s % 60).padStart(2, '0');
                return `${mm}:${ss}`;
            }
        }

        // menampilkan pilihan ganda
        document.addEventListener('DOMContentLoaded', function() {
            loadQuiz();
            submitButton();
            hitungWaktu();
        });
    </script>
</x-app-layout>
