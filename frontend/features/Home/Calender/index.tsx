import FullCalender from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { Event } from '@/types/generated/api';
import type { DatesSetArg } from '@fullcalendar/core';
import { DateClickArg } from '@fullcalendar/interaction';

type Props = {
  events: Event[];
  selectedDate: string;
  handleDatesSet: (data: DatesSetArg) => Promise<void>;
  handleChangeDate: (data: DateClickArg) => void;
};

export const Calender = ({ events, selectedDate, handleDatesSet, handleChangeDate }: Props) => {
  const eventsDate = new Set(
    events.filter(ev => ev.start_datetime).map(ev => ev.start_datetime.slice(0, 10))
  );
  return (
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
        titleFormat={{ year: 'numeric', month: 'numeric' }}
        dayCellClassNames={args => {
          const y = String(args.date.getFullYear());
          const m = String(args.date.getMonth() + 1).padStart(2, '0');
          const d = String(args.date.getDate()).padStart(2, '0');
          const cellDate = `${y}-${m}-${d}`;
          const hasEvent = eventsDate.has(cellDate);
          const classNames: string[] = [];

          if (cellDate === selectedDate) {
            classNames.push('is-selected');
          }

          if (hasEvent) {
            classNames.push('has-event');
          }

          return classNames;
        }}
        dayCellContent={args => {
          return args.dayNumberText.replace('日', '');
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
  );
};
