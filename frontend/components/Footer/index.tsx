'use client';

import { useAuthState } from '@/context/AuthContext';
import { IoMdHome } from 'react-icons/io';
import { TbBuildingStore } from 'react-icons/tb';
import { MdFavoriteBorder } from 'react-icons/md';
import { IoMdPerson } from 'react-icons/io';

export const Footer = (): React.JSX.Element => {
  const { user } = useAuthState();

  if (!user) return <></>;
  return (
    <div className="fixed bottom-0 left-0 w-full bg-pink-200 z-20">
      <div className="flex items-center justify-between min-h-[64px] px-6 max-w-6xl mx-auto">
        <IoMdHome color="#ffffff" size="2.2em" />
        <TbBuildingStore color="#ffffff" size="2.2em" />
        <MdFavoriteBorder color="#ffffff" size="2.2em" />
        <IoMdPerson color="#ffffff" size="2.2em" />
      </div>
    </div>
  );
};
