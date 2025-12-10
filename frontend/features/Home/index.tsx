'use client';

import { FavoriteFacilities } from '@/features/Home/FavoriteFacility';
import { TodayEvents } from '@/features/Home/TodayEvent/TodoEvents';
import axios from 'axios';
import { useEffect, useState } from 'react';
import { RequireAuth } from '@/components/RequireAuth';
import FullCalender from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import type { DatesSetArg } from '@fullcalendar/core';
import interactionPlugin, { DateClickArg } from '@fullcalendar/interaction';

type Event = {
  id: number;
  title: string;
  description: string;
  start_datetime: string;
  end_datetime: string;
  capacity: number;
  memo: string;
};

type FacilityFavorite = {
  id: number;
  name: string;
  address: string;
  rating: number;
};

export const Home = (): React.JSX.Element => {
  const [events, setEvents] = useState<Event[]>([]);
  const [facilityFavorities, setFacilityFavorities] = useState<FacilityFavorite[]>([]);
  const [selectedDate, setSelectedDate] = useState<string | null>(null);

  useEffect(() => {
    const fetchWeek = async () => {
      const token = localStorage.getItem('token');
      try {
        const res = await axios.get(`${process.env.NEXT_PUBLIC_BACKEND_URL}/api/`, {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json',
          },
        });
        setEvents(res.data.data.events);
        setFacilityFavorities(res.data.data.facilityFavorities);

        const todayStr = new Date().toISOString().slice(0, 10);
        setSelectedDate(todayStr);
      } catch (error) {
        console.error('トップページデータ取得エラー:', error);
      }
    };
    fetchWeek();
  }, []);

  const handleDatesSet = async (data: DatesSetArg) => {
    const year = data.view.currentStart.getFullYear();
    const month = data.view.currentStart.getMonth() + 1;
    const token = localStorage.getItem('token');

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

  return (
    <RequireAuth>
      <div className="flex items-center justify-center  bg-gradient-to-tr">
        <div className="relative w-3/4 sm:max-w-md md:max-w-lg lg:max-w-xl p-5 flex flex-col space-y-4">
          <div className="w-full">
            <FullCalender
              plugins={[dayGridPlugin, interactionPlugin]}
              initialView="dayGridMonth"
              weekends={true}
              events={events.map(ev => ({
                id: String(ev.id),
                title: ev.title,
                start: ev.start_datetime,
                end: ev.end_datetime,
              }))}
              eventDisplay="list-item"
              height="auto"
              expandRows={true}
              locale="ja"
              dayCellContent={args => {
                const original = args.dayNumberText;
                const number = original.replace('日', '');
                return { domNodes: [document.createTextNode(number)] };
              }}
              dayCellClassNames={args => {
                const y = String(args.date.getFullYear());
                const m = String(args.date.getMonth() + 1).padStart(2, '0');
                const d = String(args.date.getDate()).padStart(2, '0');
                const cellDate = `${y}-${m}-${d}`;
                return cellDate === selectedDate ? ['bg-blue-200'] : [];
              }}
              headerToolbar={{
                left: 'prev',
                center: 'title',
                right: 'next',
              }}
              datesSet={handleDatesSet}
              dateClick={handleChangeDate}
            />
          </div>
          <TodayEvents
            todayEvents={events.filter(ev => ev.start_datetime.slice(0, 10) === selectedDate)}
          />
          <FavoriteFacilities facilityFavorities={facilityFavorities} />
          <div className="w-full bg-pink-300 text-white p-2 rounded mt-6">
            <div className="flex justify-center">
              <button className="font-semibold px-6 py-2 rounded">施設を探す</button>
            </div>
          </div>
        </div>
      </div>
    </RequireAuth>
  );
};
