<x-app-layout>

    <div class="mx-auto max-w-6xl px-4">
        <div class="page-container mb-6 bg-white pb-4 shadow-xl">
            <div class="mb-6 mt-6 px-4 pb-6 pt-8 sm:px-6">
                <h1 class="mb-6 text-center text-2xl font-bold text-gray-900">Essay Assignment</h1>
                <form method="POST" action="">

                    @csrf
                    <div class="mx-4 my-4 rounded-2xl bg-gradient-to-r from-[#20C896] to-[#259D7A] px-5 py-5 shadow-xl">
                        <div class="mt-4 rounded-lg bg-transparent p-4">
                            <div class="mb-4 flex items-center justify-between font-semibold text-gray-800">
                                <p class="m-2 mb-3 ml-5 p-2 px-6 text-2xl">Iki Judul Materi e Pling</p>
                                <p class="m-2 mb-3 mr-8 p-2 px-6">
                                    Time: <span id="time" class="font-bold">10:00</span>
                                </p>
                            </div>

                            <div class="mx-12 mb-5 h-3 w-auto border-b-4 border-t-2 border-slate-700"></div>

                            <ol class="m-2 mb-3 ml-5 list-decimal space-y-3 p-2 px-6 text-gray-900">
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
                            <div class="m-2 mx-5 mb-3 rounded-xl border border-gray-200 bg-white p-2 px-6 shadow-inner">

                                <div class="border-t border-gray-200 pt-3">
                                    <textarea name="essay_answer" class="min-h-[120px] w-full resize-none border-0 p-2 text-gray-800 placeholder-gray-400 focus:outline-none" placeholder="Tulis jawabanmu di sini..."></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="buttons" class="justify-items-center py-6">
                        {{-- <div class="invisible">
                                    <h1><button
                                            class="p-3 px-6 rounded-xl  bg-gradient-to-r from-[#20C896] to-[#259D7A] font-black"><a
                                                href="#">Back</a></button></h1>
                                </div> --}}
                        <div>
                            <button type="submit" class="rounded-xl bg-gradient-to-r from-[#20C896] to-[#259D7A] p-3 px-6 font-black">Kirim
                                Quiz</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
