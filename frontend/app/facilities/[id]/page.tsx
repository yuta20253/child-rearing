import { FacilityPage } from '@/features/Facility';

type FacilityDetailProps = {
  params: Promise<{ id: string }>;
};

const FacilityDetail = async ({ params }: FacilityDetailProps) => {
  const { id } = await params;

  return <FacilityPage id={id} />;
};

export default FacilityDetail;
