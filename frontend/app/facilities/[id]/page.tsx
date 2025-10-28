import { FacilityPage } from '@/features/Facility';

type FacilityDetailProps = {
  params: { id: string };
};

const FacilityDetail = ({ params }: FacilityDetailProps) => {
    return <FacilityPage id={params.id} />;
};

export default FacilityDetail;
