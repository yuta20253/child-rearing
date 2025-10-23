'use client';

type FormDataType = {
  name: string;
};

import { useRouter } from 'next/navigation';

export const useSubmit = () => {
  const router = useRouter();
  const onSubmit = async (data: FormDataType) => {
    router.push(`/facilities?name=${data.name}`);
  };
  return { onSubmit };
};
