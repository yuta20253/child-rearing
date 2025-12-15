import { SetStateAction } from 'react';
import type { DatesSetArg } from '@fullcalendar/core';
import { DateClickArg } from '@fullcalendar/interaction';

type Props = {
  setSelectedDate: (value: SetStateAction<string>) => void;
  setCurrentMonth: (value: SetStateAction<YearMonth>) => void;
};

type YearMonth = {
  year: number;
  month: number;
};

export const handleDateAction = ({ setSelectedDate, setCurrentMonth }: Props) => {
  const handleDatesSet = async (data: DatesSetArg) => {
    const year = data.view.currentStart.getFullYear();
    const month = data.view.currentStart.getMonth() + 1;

    setCurrentMonth(prev => {
      if (prev.year === year && prev.month === month) return prev;

      return { year, month };
    })
  };

  const handleChangeDate = (data: DateClickArg) => {
    setSelectedDate(data.dateStr);
  };

  return { handleDatesSet, handleChangeDate };
};
