<x-app-layout>

    <div class="max-w-6xl mx-auto px-4">
        <div class="pb-4 mb-6 page-container bg-white shadow-xl">
            <div class="pt-8 px-4 pb-6 sm:px-6 mt-6 mb-6">
                <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Quiz Assignment Result</h1>
                <div class="my-4 mx-4 py-5 px-5 rounded-2xl bg-gradient-to-r from-[#20C896] to-[#259D7A]">
                    <div class="text-gray-800 font-semibold mb-4 flex justify-between items-center">
                        <p class=" m-2 ml-5 mb-3 p-2 px-6 text-2xl">Iki Judul Materi e Pling</p>
                        <p class=" m-2 mr-8 mb-3 p-2 px-6">
                            Time: <span id="time" class="font-bold">06:34</span>
                        </p>
                    </div>

                    <div class="mb-5 mx-12 h-3 w-auto border-b-4 border-t-2 border-slate-700"></div>

                    <div class="mb-6">
                        <fieldset>
                            {{-- hasil quiz dan jawaban peserta --}}
                            <div id="pilihanGanda">
                                <div class="px-4 py-4 flex">
                                    <div class="flex-shrink-0 w-4">
                                        <h1 class="text-xl font-extrabold">1.</h1>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="block text-gray-800 font-semibold py-4 px-4 mb-3 mx-2 rounded-xl bg-slate-200">
                                            Berapa waktu kompleksitas untuk mencari elemen di dalam Binary Search Tree
                                            yang seimbang?
                                        </div>

                                        <div class="flex flex-col sm:grid sm:grid-cols-2 gap-2 gap-x-16">
                                            
                                            <label
                                                class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-200">
                                                <input type="radio" name="question1" value="O(n)"
                                                    class="form-radio h-4 w-4 text-blue-600" unchecked>
                                                <span class="text-gray-700">O(n)</span>
                                            </label>

                                            <label
                                                class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-200">
                                                <input type="radio" name="question1" value="O(log n)"
                                                    class="form-radio h-4 w-4 text-blue-600" checked>
                                                <span class="text-gray-700">O(log n)</span>
                                            </label>

                                            <label
                                                class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-200">
                                                <input type="radio" name="question1" value="O(n²)"
                                                    class="form-radio h-4 w-4 text-blue-600" unchecked>
                                                <span class="text-gray-700">O(n²)</span>
                                            </label>

                                            <label
                                                class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-200">
                                                <input type="radio" name="question1" value="O(1)"
                                                    class="form-radio h-4 w-4 text-blue-600" unchecked>
                                                <span class="text-gray-700">O(1)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 py-4 flex">
                                    <div class="flex-shrink-0 w-4">
                                        <h1 class="text-xl font-extrabold">2.</h1>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="block text-gray-800 font-semibold py-4 px-4 mb-3 mx-2 rounded-xl bg-slate-200">
                                            Algoritma mana yang menggunakan prinsip 'Divide and Conquer'?
                                        </div>

                                        <div class="flex flex-col sm:grid sm:grid-cols-2 gap-2 gap-x-16">
                                            
                                            <label
                                                class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-200">
                                                <input type="radio" name="question2" value="Linear Search"
                                                    class="form-radio h-4 w-4 text-blue-600" unchecked>
                                                <span class="text-gray-700">Linear Search</span>
                                            </label>

                                            <label
                                                class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-200">
                                                <input type="radio" name="question2" value="Bubble Sort"
                                                    class="form-radio h-4 w-4 text-blue-600" checked>
                                                <span class="text-gray-700">Bubble Sort</span>
                                            </label>

                                            <label
                                                class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-200">
                                                <input type="radio" name="question2" value="Merge Sort"
                                                    class="form-radio h-4 w-4 text-blue-600" unchecked>
                                                <span class="text-gray-700">Merge Sort</span>
                                            </label>

                                            <label
                                                class="flex items-center space-x-3 py-4 px-4 my-0 mx-2 rounded-xl bg-slate-200">
                                                <input type="radio" name="question2" value="Insertion Sort"
                                                    class="form-radio h-4 w-4 text-blue-600" unchecked>
                                                <span class="text-gray-700">Insertion Sort</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div id="quizResult" class=" m-2 ml-5 mb-3 p-2 px-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-900">Hasil Quiz Anda:</h2>
                        <p class="text-lg text-gray-800 mb-2">Benar: <span class="font-semibold">0</span></p>
                        <p class="text-lg text-gray-800 mb-2">Nilai: <span class="font-semibold">AAAA</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
