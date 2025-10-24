'use client';

import { useRouter } from 'next/navigation';

type FormDataType = {
  name: string;
};

export const useSubmit = (reset?: (value?: FormDataType) => void) => {
  const router = useRouter();
  const onSubmit = async (data: FormDataType) => {
    router.push(`/facilities?name=${data.name}`);

    if (reset) {
      reset({ name: '' });
    }
  };
  return { onSubmit };
};
