<x-app-layout>
    <div class="mx-auto max-w-3xl px-4 py-8">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-900">Hasil Quiz</h1>
            <p class="mt-2 text-gray-600">{{ $assignment->title }}</p>
        </div>

        <div class="mb-8 rounded-xl bg-white p-6 shadow-sm">
            <div class="flex justify-between text-lg font-bold">
                <span>Skor Anda:</span>
                <span class="text-indigo-600">{{ $submission->score }} poin</span>
            </div>
            <p class="mt-2 text-sm text-gray-500">
                Jawaban Anda telah dinilai. Di bawah ini ditampilkan status setiap jawaban.
            </p>
        </div>

        <div class="space-y-6">
            @foreach($answers as $index => $answer)
                <div class="rounded-lg border bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-start justify-between">
                        <span class="text-lg font-semibold">Soal {{ $loop->iteration }}</span>
                        @if($answer->is_correct)
                            <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">Benar</span>
                        @else
                            <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800">Salah</span>
                        @endif
                    </div>
                    <p class="text-gray-800">{{ $answer->question->question_text }}</p>

                    {{-- Tampilkan pilihan yang dipilih --}}
                    <div class="mt-3">
                        <p class="text-sm text-gray-600">
                            Jawaban Anda:
                            @php
                                $optionMap = [
                                    'option_a' => 'A',
                                    'option_b' => 'B',
                                    'option_c' => 'C',
                                    'option_d' => 'D',
                                ];
                                $selectedLabel = $optionMap[$answer->selected_option] ?? $answer->selected_option;
                                $selectedText = $answer->question->{$answer->selected_option} ?? '—';
                            @endphp
                            <strong>{{ $selectedLabel }}.</strong> {{ $selectedText }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('kelas', $assignment->course_class_id) }}"
               class="inline-block rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700">
                Kembali ke Kelas
            </a>
        </div>
    </div>
</x-app-layout>
