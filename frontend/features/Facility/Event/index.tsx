'use client';

import { format } from 'date-fns';
import { ja } from 'date-fns/locale';

type Props = {
  event: {
    id: number;
    title: string;
    start_datetime: string;
    end_datetime: string;
  };
  showCalendar?: boolean;
  largeTitle?: boolean;
  inline?: boolean;
};

export const EventItem = ({
  event,
  showCalendar = false,
  largeTitle = false,
  inline = false,
}: Props) => {
  const start = new Date(event.start_datetime);
  const end = new Date(event.end_datetime);

  const now = new Date();

    const isBefore = now < start;
    const isOnGoing = now >= start && now <= end;
    const isFinished = now > end;

  return (
    <div className="flex gap-4">
      {showCalendar && (
        <div className="flex-shrink-0 w-14 rounded-xl border border-gray-200 overflow-hidden text-center bg-white">
          <div className="bg-blue-600 text-white text-[10px] py-1 font-medium">
            {format(start, 'M月')}
          </div>

          <div className="py-2">
            <div className="text-xl font-bold leading-none text-gray-900">{format(start, 'd')}</div>

            <div className="text-[10px] text-gray-500 mt-1">
              {format(start, 'E', { locale: ja })}
            </div>
          </div>
        </div>
      )}
      {inline ? (
        <div className="flex flex-col gap-1 min-w-0 w-full">

            {/* タイトル */}
            <p className="text-sm font-semibold text-gray-900 leading-snug truncate">
            {event.title}
            </p>

            {/* 下：時間 + バッジ */}
            <div className="flex items-center gap-2 text-xs">

            <p className="text-blue-600 font-medium">
                🕒 {format(start, 'M/d HH:mm')} ~ {format(end, 'M/d HH:mm')}
            </p>

            <div className="flex gap-1 ml-auto shrink-0">
                {isOnGoing && (
                <span className="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-600">
                    開催中
                </span>
                )}
                {isBefore && (
                <span className="px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-100 text-blue-600">
                    予定
                </span>
                )}
                {isFinished && (
                <span className="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-100 text-gray-500">
                    終了
                </span>
                )}
            </div>

            </div>
        </div>
      ) : (
        <div className="min-w-0 flex-1">
          <p
            className={`text-gray-900 leading-snug ${
              largeTitle ? 'text-base font-bold line-clamp-2' : 'text-sm font-semibold'
            }`}
          >
            {event.title}
          </p>
            {isOnGoing && (
            <span className="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-600">
                開催中
            </span>
            )}

            {isBefore && (
            <span className="px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-100 text-blue-600">
                予定
            </span>
            )}

            {isFinished && (
            <span className="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-100 text-gray-500">
                終了
            </span>
            )}
          <p className="text-xs text-gray-500 mt-2">
            🕒 {format(start, 'M/d HH:mm')} ~ {format(end, 'M/d HH:mm')}
          </p>
        </div>
      )}
    </div>
  );
};
