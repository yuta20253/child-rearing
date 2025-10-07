import React from 'react';

type Props = {
  rating: number;
  max?: number;
};

export const StarRating = ({ rating, max = 5 }: Props) => {
  return (
    <>
      {Array.from({ length: max }, (_, i) => (
        <span key={i} className={i < rating ? 'text-yellow-500' : 'text-gray-300'}>
          ★
        </span>
      ))}
    </>
  );
};
