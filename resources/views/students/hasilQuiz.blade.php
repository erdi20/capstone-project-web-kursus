<x-app-layout>

    <div class="max-w-6xl mx-auto px-4">
        <div class="pb-4 mb-6 page-container bg-white shadow-xl">
            <div class="pt-8 px-4 pb-6 sm:px-6 mt-6 mb-6">
                <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Quiz Assignment</h1>
                <div class="my-4 mx-4 py-5 px-5 bg-blue-400 rounded-2xl">
                    <div class="text-gray-800 font-semibold mb-4 flex justify-between items-center">
                        <p class=" m-2 ml-5 mb-3 p-2 px-6 text-2xl">Ga ngerti iki nko bakal e diisi opo</p>
                        <p class=" m-2 mr-8 mb-3 p-2 px-6">
                            Time: <span id="time" class="font-bold">06:34</span>
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

                    <div id="quizResult" class=" py-6">
                        <div class="bg-green-200 p-6 rounded-xl w-3/4">
                            <h2 class="text-xl font-bold text-green-800 mb-4">Your Score: 80%</h2>
                            <p class="text-green-700">Great job! You answered 4 out of 5 questions correctly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var quiz = [{
                "id": 1,
                "pertanyaan": "Berapa waktu kompleksitas untuk mencari elemen di dalam Binary Search Tree yang seimbang?",
                "pilihan": [{
                        "label": "A",
                        "teks": "O(n)",
                        "status" : "unchecked"
                    },
                    {
                        "label": "B",
                        "teks": "O(log n)",
                        "status" : "checked"
                    },
                    {
                        "label": "C",
                        "teks": "O(n²)",
                        "status" : "unchecked"
                    },
                    {
                        "label": "D",
                        "teks": "O(1)",
                        "status" : "unchecked"
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
                        "teks": "Linear Search",
                        "status" : "checked"
                    },
                    {
                        "label": "B",
                        "teks": "Bubble Sort",
                        "status" : "unchecked"
                    },
                    {
                        "label": "C",
                        "teks": "Merge Sort",
                        "status" : "unchecked"
                    },
                    {
                        "label": "D",
                        "teks": "Insertion Sort",
                        "status" : "unchecked"
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
                        "teks": "Hash Map + Doubly Linked List",
                        "status" : "checked"
                    },
                    {
                        "label": "B",
                        "teks": "Array saja",
                        "status" : "unchecked"
                    },
                    {
                        "label": "C",
                        "teks": "Single Linked List",
                        "status" : "unchecked"
                    },
                    {
                        "label": "D",
                        "teks": "Queue biasa",
                        "status" : "unchecked"
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
                                                    class="block text-gray-800 font-semibold py-4 px-4 mb-3 mx-2 rounded-xl bg-slate-200">
                                                    ${el.pertanyaan}
                                                </div>
                                                
                                                <div class="flex flex-col sm:grid sm:grid-cols-2 gap-2 gap-x-16">`

                
                el.pilihan.forEach(pil => {

                    if(pil.status == "checked"){
                        classColor = pil.label == el.jawaban_benar ? "bg-green-200" : "bg-red-300";
                    } else if (pil.status == "unchecked") {
                        classColor = "bg-slate-100";
                    }

                    teksQuiz += `<label
                                                        class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl ${classColor}">
                                                        <input type="radio" name="question${el.id}" value="${pil.teks}"
                                                            class="form-radio h-4 w-4 text-blue-600" ${
                                                                pil.status === "checked" ? "checked" : ""
                                                            }>
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

        // menampilkan pilihan ganda
        document.addEventListener('DOMContentLoaded', function() {
            loadQuiz();
        });
    </script>
</x-app-layout>
