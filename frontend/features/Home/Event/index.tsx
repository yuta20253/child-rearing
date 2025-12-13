import React from 'react';
import { formatTime } from '@/utils/formatDate';

export type Event = {
  title: string;
  start_datetime: string;
  end_datetime: string;
};

type Props = {
  event: Event;
};

export const Event = ({ event }: Props) => {
  return (
    <div className="flex items-center space-x-3">
      <div className="text-blue-500 text-lg flex items-center justify-center w-10 h-10">Logo</div>
      <div className="flex flex-col justify-center">
        <p className="text-sm font-semibold text-gray-800 leading-tight">{event.title}</p>
        <p className="text-xs text-gray-500 mt-[2px]">
          {formatTime(event.start_datetime)} ~ {formatTime(event.end_datetime)}
        </p>
      </div>
    </div>
  );
};
