import { FacilityWithRelations } from '@/types/generated/api';
import { FaStar } from 'react-icons/fa';
import { truncate } from '@/utils/truncate';

type FacilityProps = {
  facility: FacilityWithRelations;
};

export const FacilityReviewList = ({ facility }: FacilityProps) => {
  const reviews = facility.reviews ?? [];

  return (
    <>
      <div className="px-4 pt-3 pb-2 border-b">
        <h2 className="text-sm font-semibold text-gray-800 flex items-center gap-2">
          <span className="text-lg">💬</span>
          <span>口コミ</span>
        </h2>
        <p className="mt-1 text-[11px] text-gray-400">実際に利用した人の感想をチェックできます。</p>
      </div>

      {reviews.length === 0 ? (
        <div className="px-4 py-8 text-center text-gray-400">
          <div className="text-3xl mb-2">📝</div>
          <p className="text-sm font-medium mb-1">まだ口コミがありません</p>
          <p className="text-[11px]">利用したことがあれば、最初の口コミを投稿してみましょう。</p>
        </div>
      ) : (
        <ul className="divide-y">
          {reviews.map(review => (
            <li key={review.id} className="px-4 py-3">
              <div className="flex items-center justify-between mb-1.5">
                <div className="flex items-center space-x-0.5">
                  {[1, 2, 3, 4, 5].map(num => {
                    const isSelected = num <= (review.rating ?? 0);
                    return (
                      <FaStar
                        key={num}
                        className={isSelected ? 'text-yellow-400' : 'text-gray-300'}
                        size={14}
                      />
                    );
                  })}
                </div>
                <span className="text-[11px] text-gray-500">
                  {review.user?.name || '匿名ユーザー'}
                </span>
              </div>
              <p className="text-xs text-gray-700 leading-relaxed whitespace-pre-line">
                {truncate(review.comment, 80)}
              </p>
            </li>
          ))}
        </ul>
      )}
    </>
  );
};
