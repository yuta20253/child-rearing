import { FacilityWithRelations } from "@/types/generated/api";
import { Star } from "../../Star";
import { truncate } from "@/utils/truncate";

type FacilityProps = {
  facility: FacilityWithRelations;
};

export const FacilityReviewList = ({ facility }: FacilityProps ) => {
    return (
        <div className="px-4">
            <h3 className="text-lg font-semibold text-gray-700 mb-2">💬口コミ</h3>
            {
                facility.reviews && facility.reviews?.length > 0 ? (
                    facility.reviews?.map((review) => (
                            <div key={review.id} className="p-4">
                                <div className="flex justify-between items-center mb-2">
                                    <div className="flex items-center space-x-1">
                                        {
                                            [1, 2, 3, 4, 5].map((num) => (
                                                <Star key={num} selected={ num <= (review.rating ?? 0) } />
                                            ))
                                        }
                                    </div>
                                    <span className="text-sm text-gray-500">{review.user?.name}</span>
                                </div>
                                <p className="text-gray-700 leading-relaxed whitespace-pre-line">{truncate(review.comment, 20)}</p>
                            </div>
                        ))
                ) : (
                    <div className="text-gray-500 text-sm">口コミがありません。</div>
                )
            }
        </div>
    );
};
