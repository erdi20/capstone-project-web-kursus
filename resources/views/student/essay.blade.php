<x-app-layout>

    <div class="max-w-6xl mx-auto px-4">
        <div class="pb-4 mb-6 page-container bg-white shadow-xl">
            <div class="pt-8 px-4 pb-6 sm:px-6 mt-6 mb-6">
                <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Essay Assignment</h1>
                <form method="POST" action="{{ route('course.submitEssay') }}">

                    @csrf
                    <div class=" bg-gradient-to-r from-[#20C896] to-[#259D7A] rounded-2xl my-4 mx-4 py-5 px-5 shadow-xl">
                        <div class="mt-4 bg-transparent rounded-lg p-4">
                            <div class="text-gray-800 font-semibold mb-4 flex justify-between items-center">
                                <p class=" m-2 ml-5 mb-3 p-2 px-6 text-2xl">Iki Judul Materi e Pling</p>
                                <p class=" m-2 mr-8 mb-3 p-2 px-6">
                                    Time: <span id="time" class="font-bold">10:00</span>
                                </p>
                            </div>

                            <div class="mb-5 mx-12 h-3 w-auto border-b-4 border-t-2 border-slate-700"></div>

                            <ol class="list-decimal  m-2 ml-5 mb-3 p-2 px-6 text-gray-900 space-y-3">
                                <li>Naratif teknis adalah teks atau penulisan berbentuk narasi (cerita) yang digunakan
                                    untuk
                                    menjelaskan proses, prosedur, atau teknologi secara sistematis.</li>
                                <li>Naratif teknis adalah teks atau penulisan berbentuk narasi (cerita) yang digunakan
                                    untuk
                                    menjelaskan proses, prosedur, atau teknologi secara sistematis.</li>
                                <li>Naratif teknis adalah teks atau penulisan berbentuk narasi (cerita) yang digunakan
                                    untuk
                                    menjelaskan proses, prosedur, atau teknologi secara sistematis.</li>
                            </ol>
                            <div
                                class=" m-2 mx-5 mb-3 p-2 px-6 bg-white rounded-xl shadow-inner border border-gray-200">
                                <div class="flex items-center space-x-3 mb-2">
                                    <div class="flex space-x-2 text-gray-600">
                                        <button type="button" class="p-2 rounded hover:bg-gray-100 focus:outline-none"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z" />
                                            </svg>
                                        </button>
                                        <button type="button" class="p-2 rounded hover:bg-gray-100 focus:outline-none"
                                            title="Bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M6 4h4a3 3 0 010 6H6V4zm0 8h5a3 3 0 010 6H6v-6z" />
                                            </svg>
                                        </button>
                                        <button type="button" class="p-2 rounded hover:bg-gray-100 focus:outline-none"
                                            title="Trash">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H3a1 1 0 100 2h14a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zM7 7a1 1 0 011 1v7a1 1 0 11-2 0V8a1 1 0 011-1zm5 1a1 1 0 00-1 1v7a1 1 0 102 0V9a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-3">
                                    <textarea name="essay_answer"
                                        class="w-full min-h-[120px] text-gray-800 placeholder-gray-400 focus:outline-none resize-none p-2 border-0"
                                        placeholder="Tulis jawabanmu di sini...">Rafli kok ganteng si</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="buttons" class=" py-6 justify-items-center">
                        {{-- <div class="invisible">
                                    <h1><button
                                            class="p-3 px-6 rounded-xl  bg-gradient-to-r from-[#20C896] to-[#259D7A] font-black"><a
                                                href="#">Back</a></button></h1>
                                </div> --}}
                        <div>
                            <button type="submit"
                                class="p-3 px-6 rounded-xl  bg-gradient-to-r from-[#20C896] to-[#259D7A] font-black">Kirim
                                Quiz</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
