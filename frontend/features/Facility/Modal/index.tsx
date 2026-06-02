'use client';

import { MouseEvent } from 'react';
import {
  SubmitHandler,
  UseFormHandleSubmit,
  UseFormRegister,
  UseFormSetValue,
} from 'react-hook-form';
import { FaRegStar, FaStar } from 'react-icons/fa';

type ReviewForm = {
  comment: string;
  rating: number;
};

type Props = {
  setIsModalOpen: (open: boolean) => void;
  handleSubmit: UseFormHandleSubmit<ReviewForm>;
  onSubmit: SubmitHandler<ReviewForm>;
  register: UseFormRegister<ReviewForm>;
  setValue: UseFormSetValue<ReviewForm>;
  currentRating: number;
  isSubmitting: boolean;
};

export const FacilityReviewModal = ({
  setIsModalOpen,
  handleSubmit,
  onSubmit,
  register,
  setValue,
  currentRating,
  isSubmitting,
}: Props) => {
  return (
    <div
      className="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 px-4"
      onClick={() => setIsModalOpen(false)}
    >
      <div
        className="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl"
        onClick={(event: MouseEvent<HTMLDivElement>) => event.stopPropagation()}
      >
        <div className="flex items-start justify-between gap-4">
          <div>
            <h3 className="text-lg font-semibold text-gray-900">口コミを投稿</h3>
          </div>

          <button
            type="button"
            onClick={() => setIsModalOpen(false)}
            className="text-gray-400 transition hover:text-gray-700"
          >
            ×
          </button>
        </div>

        <div className="mt-6 text-sm text-gray-700">
          <form
            onSubmit={handleSubmit(onSubmit)}
            onClick={e => e.stopPropagation()}
            className="space-y-4"
          >
            <div>
              <p className="mb-1 text-xs text-gray-500">評価</p>

              <div className="flex gap-1">
                {[1, 2, 3, 4, 5].map(num => (
                  <button key={num} type="button" onClick={() => setValue('rating', num)}>
                    {num <= currentRating ? (
                      <FaStar className="text-yellow-400" />
                    ) : (
                      <FaRegStar className="text-gray-300" />
                    )}
                  </button>
                ))}
              </div>
            </div>

            <div>
              <p className="mb-1 text-xs text-gray-500">コメント</p>

              <textarea
                {...register('comment', { required: true })}
                className="w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                rows={4}
                placeholder="感想を書いてください"
              />
            </div>

            <div className="flex mt-6 justify-end gap-1">
              <button
                type="submit"
                disabled={isSubmitting}
                className="rounded-full bg-blue-500 px-4 py-2 text-sm text-white hover:opacity-80 disabled:opacity-50"
              >
                投稿する
              </button>

              <button
                type="button"
                onClick={() => setIsModalOpen(false)}
                className="rounded-full bg-gray-100 px-4 py-2 text-sm text-gray-700 hover:bg-gray-200"
              >
                閉じる
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};
