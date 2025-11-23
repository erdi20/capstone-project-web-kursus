<x-app-layout>

    <div class="mx-auto max-w-6xl px-4">
        <div class="page-container mb-6 bg-white pb-4 shadow-xl">
            <div class="mb-6 mt-6 px-4 pb-6 pt-8 sm:px-6">
                <h1 class="mb-6 text-center text-2xl font-bold text-gray-900">Quiz Assignment</h1>
                <form action="" method="POST">
                    <div class="mx-4 my-4 rounded-2xl bg-gradient-to-r from-[#20C896] to-[#259D7A] px-5 py-5">
                        @csrf

                        <div class="mb-4 flex items-center justify-between font-semibold text-gray-800">
                            <p class="m-2 mb-3 ml-5 p-2 px-6 text-2xl">Iki Judul Materi e Pling</p>
                            <p class="m-2 mb-3 mr-8 p-2 px-6">
                                Time: <span id="time" class="font-bold">10:00</span>
                            </p>
                        </div>

                        <div class="mx-12 mb-5 h-3 w-auto border-b-4 border-t-2 border-slate-700"></div>

                        <div class="mb-6">
                            <fieldset>
                                <div id="pilihanGanda">
                                    <div class="flex px-4 py-4">
                                        <div class="w-4 flex-shrink-0">
                                            <h1 class="text-xl font-extrabold">1.</h1>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="mx-2 mb-3 block rounded-xl bg-slate-200 px-4 py-4 font-semibold text-gray-800">
                                                Berapa waktu kompleksitas untuk mencari elemen di dalam Binary Search
                                                Tree
                                                yang seimbang?
                                            </div>

                                            <div class="flex flex-col gap-2 gap-x-16 sm:grid sm:grid-cols-2">

                                                <label class="mx-2 my-0 flex items-center space-x-3 rounded-xl bg-slate-200 px-4 py-4">
                                                    <input type="radio" name="question1" value="O(n)" class="form-radio h-4 w-4 text-blue-600">
                                                    <span class="text-gray-700">O(n)</span>
                                                </label>

                                                <label class="mx-2 my-0 flex items-center space-x-3 rounded-xl bg-slate-200 px-4 py-4">
                                                    <input type="radio" name="question1" value="O(log n)" class="form-radio h-4 w-4 text-blue-600">
                                                    <span class="text-gray-700">O(log n)</span>
                                                </label>

                                                <label class="mx-2 my-0 flex items-center space-x-3 rounded-xl bg-slate-200 px-4 py-4">
                                                    <input type="radio" name="question1" value="O(n²)" class="form-radio h-4 w-4 text-blue-600">
                                                    <span class="text-gray-700">O(n²)</span>
                                                </label>

                                                <label class="mx-2 my-0 flex items-center space-x-3 rounded-xl bg-slate-200 px-4 py-4">
                                                    <input type="radio" name="question1" value="O(1)" class="form-radio h-4 w-4 text-blue-600">
                                                    <span class="text-gray-700">O(1)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex px-4 py-4">
                                        <div class="w-4 flex-shrink-0">
                                            <h1 class="text-xl font-extrabold">2.</h1>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="mx-2 mb-3 block rounded-xl bg-slate-200 px-4 py-4 font-semibold text-gray-800">
                                                Algoritma mana yang menggunakan prinsip 'Divide and Conquer'?
                                            </div>

                                            <div class="flex flex-col gap-2 gap-x-16 sm:grid sm:grid-cols-2">

                                                <label class="mx-2 my-0 flex items-center space-x-3 rounded-xl bg-slate-200 px-4 py-4">
                                                    <input type="radio" name="question2" value="Linear Search" class="form-radio h-4 w-4 text-blue-600">
                                                    <span class="text-gray-700">Linear Search</span>
                                                </label>

                                                <label class="mx-2 my-0 flex items-center space-x-3 rounded-xl bg-slate-200 px-4 py-4">
                                                    <input type="radio" name="question2" value="Bubble Sort" class="form-radio h-4 w-4 text-blue-600">
                                                    <span class="text-gray-700">Bubble Sort</span>
                                                </label>

                                                <label class="mx-2 my-0 flex items-center space-x-3 rounded-xl bg-slate-200 px-4 py-4">
                                                    <input type="radio" name="question2" value="Merge Sort" class="form-radio h-4 w-4 text-blue-600">
                                                    <span class="text-gray-700">Merge Sort</span>
                                                </label>

                                                <label class="mx-2 my-0 flex items-center space-x-3 rounded-xl bg-slate-200 px-4 py-4">
                                                    <input type="radio" name="question2" value="Insertion Sort" class="form-radio h-4 w-4 text-blue-600">
                                                    <span class="text-gray-700">Insertion Sort</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div id="buttons" class="grid grid-cols-2 justify-items-center gap-4 py-6">
                        <div>
                            <h1><button class="rounded-xl bg-gradient-to-r from-[#20C896] to-[#259D7A] p-3 px-6 font-black"><a href="#">Back</a></button></h1>
                        </div>
                        <div>
                            <button type="submit" class="rounded-xl bg-gradient-to-r from-[#20C896] to-[#259D7A] p-3 px-6 font-black">Kirim Quiz</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
