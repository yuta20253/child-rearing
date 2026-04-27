type Status = 'before' | 'ongoing' | 'finished';

type Props = {
  status: Status;
};

export const EventStatusBadge = ({ status }: Props) => {
  const map = {
    ongoing: {
      label: '開催中',
      className: 'bg-red-100 text-red-600',
    },
    before: {
      label: '予定',
      className: 'bg-blue-100 text-blue-600',
    },
    finished: {
      label: '終了',
      className: 'bg-gray-100 text-gray-500',
    },
  } as const;

  const item = map[status];

  return (
    <span className={`px-2 py-0.5 text-[10px] font-bold rounded-full ${item.className}`}>
      {item.label}
    </span>
  );
};
