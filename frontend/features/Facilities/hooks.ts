'use client';

import { useRouter } from 'next/navigation';

type FormDataType = {
  name: string;
};

export const useSubmit = () => {
  const router = useRouter();
  const onSubmit = async (data: FormDataType) => {
    router.push(`/facilities?name=${data.name}`);
  };
  return { onSubmit };
};
