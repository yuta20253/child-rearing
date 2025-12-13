import { SetStateAction } from "react";
import { Event as ApiEvent } from '@/types/generated/api';
import axios from "axios";
import type { DatesSetArg } from '@fullcalendar/core'
import { DateClickArg } from '@fullcalendar/interaction';

type Props = {
    token: string | null;
    setEvents: (value: SetStateAction<ApiEvent[]>) => void;
    setSelectedDate: (value: SetStateAction<string>) => void;
}

export const handleDateAction = ({
    token,
    setEvents,
    setSelectedDate,
}: Props) => {
 const handleDatesSet = async (data: DatesSetArg) => {
    const year = data.view.currentStart.getFullYear();
    const month = data.view.currentStart.getMonth() + 1;

    try {
      const res = await axios.get(`${process.env.NEXT_PUBLIC_BACKEND_URL}/api/calendar/events`, {
        params: { year, month },
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      });
      setEvents(res.data.events);
    } catch (error) {
      console.error('月切り替えイベント取得エラー:', error);
    }
  };

 const handleChangeDate = (data: DateClickArg) => {
    setSelectedDate(data.dateStr);
  };

  return { handleDatesSet, handleChangeDate };
};
