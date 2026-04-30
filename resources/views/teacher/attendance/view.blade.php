@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Attendance Records</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">View Records</span>
            </p>
        </div>
        <div class="px-3">
            <a href="{{ route('teacher.attendance.index', $subdomain) }}" class="px-4 py-2 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl transition-all">
                <i class="fa fa-plus mr-1"></i> Add New Attendance
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h6 class="font-bold text-slate-700">Submitted Attendance Records</h6>
            <p class="text-xs text-slate-400 mt-0.5">Records cannot be edited once submitted</p>
        </div>

        @if($attendances->isEmpty())
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-calendar-alt text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No attendance records found</p>
                <p class="text-slate-400 text-sm mt-1">Start recording attendance from the dashboard.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Student</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Subject</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Class</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase">Score</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Rating</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Term</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Session</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-black text-xs font-bold">
                                        {{ strtoupper(substr($attendance->student->name, 0, 2)) }}
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $attendance->student->name }}</span>
                                </div>
                             </td>
                            <td class="px-6 py-3">
                                <span class="text-sm text-slate-600">{{ $attendance->subject->name ?? 'N/A' }}</span>
                             </td>
                            <td class="px-6 py-3">
                                <span class="text-xs font-semibold bg-purple-50 text-purple-600 px-2 py-1 rounded-lg">
                                    {{ $attendance->class->name ?? 'N/A' }}
                                </span>
                             </td>
                            <td class="px-6 py-3 text-center">
                                <span class="font-bold text-slate-700">{{ $attendance->score }}/10</span>
                             </td>
                            <td class="px-6 py-3">
                                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ \App\Models\Attendance::getRatingColor($attendance->rating) }}">
                                    {{ $attendance->rating }}
                                </span>
                             </td>
                            <td class="px-6 py-3">
                                <span class="text-sm text-slate-600">{{ $attendance->term }}</span>
                             </td>
                            <td class="px-6 py-3">
                                <span class="text-sm text-slate-600">{{ $attendance->session }}</span>
                             </td>
                            <td class="px-6 py-3">
                                <span class="text-sm text-slate-500">{{ $attendance->created_at->format('d M Y') }}</span>
                             </td>
                         </tr>
                        @endforeach
                    </tbody>
                 </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

</div>

@endsection