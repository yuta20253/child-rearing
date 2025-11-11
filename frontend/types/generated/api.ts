/* eslint-disable */
/* tslint:disable */
// @ts-nocheck
/*
 * ---------------------------------------------------------------
 * ## THIS FILE WAS GENERATED VIA SWAGGER-TYPESCRIPT-API        ##
 * ##                                                           ##
 * ## AUTHOR: acacode                                           ##
 * ## SOURCE: https://github.com/acacode/swagger-typescript-api ##
 * ---------------------------------------------------------------
 */

/**
 * Addressモデル
 * 町域の情報
 */
export interface Address {
  /** @example 1 */
  id?: number;
  /** @example 1 */
  municipality_id?: number;
  /** @example "1234567" */
  postal_code?: string;
  /** @example "" */
  town?: string | null;
  chome?: string | null;
  banchi?: string | null;
  go?: string | null;
  building?: string | null;
  room?: string | null;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  created_at?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  updated_at?: string;
}

export type AddressWithRelations = Address & {
  municipality?: MunicipalityWithPrefecture;
};

/**
 * Facilityモデル
 * 施設情報
 */
export interface Facility {
  /** @example 1 */
  id?: number;
  /** @example "北区役所" */
  name?: string;
  /** @example "" */
  image?: string | null;
  /**
   * @format float
   * @example 35.6895
   */
  latitude?: number;
  /**
   * @format float
   * @example 139.6917
   */
  longitude?: number;
  /** @example "設備情報です。" */
  equipment?: string;
  /** @example "設備情報です。" */
  description?: string;
  /** @example 1 */
  address_id?: number;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  created_at?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  updated_at?: string;
}

export type FacilityWithRelations = Facility & {
  address?: AddressWithRelations;
  reviews?: FacilityReviewWithUser[];
  /** 電話番号 */
  phone?: Telphone;
  hours?: FacilityHour[];
};

/**
 * FacilityHourモデル
 * 営業日時の情報
 */
export interface FacilityHour {
  /** @example 1 */
  id?: number;
  /** @example 1 */
  day_of_week?: number;
  /**
   * 曜日名（日本語）
   * @example "月曜日"
   */
  day_of_week_label?: string;
  /**
   * 開始時刻
   * @format time
   * @example "09:00"
   */
  open_time?: string;
  /**
   * 終了時刻
   * @format time
   * @example "18:00"
   */
  close_time?: string;
  /** @example "備考" */
  note?: string;
}

/**
 * FacilityReviewモデル
 * 施設の口コミ情報
 */
export interface FacilityReview {
  /** @example 1 */
  id?: number;
  /** @example 1 */
  facility_id?: number;
  /** @example 2 */
  user_id?: number;
  /** @example 3 */
  rating?: number;
  /** @example "施設の感想です。" */
  comment?: string | null;
  /**
   * @format date-time
   * @example "2025-10-24T11:08:53Z"
   */
  created_at?: string;
  /**
   * @format date-time
   * @example "2025-10-24T11:08:53Z"
   */
  updated_at?: string;
}

export type FacilityReviewWithUser = FacilityReview & {
  /** ユーザー情報 */
  user?: User;
};

/**
 * Municipalityモデル
 * 市区町村の情報
 */
export interface Municipality {
  /** @example 1 */
  id?: number;
  /** @example 1 */
  prefecture_id?: number;
  /** @example "北区" */
  name?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  created_at?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  updated_at?: string;
}

export type MunicipalityWithPrefecture = Municipality & {
  /** 都道府県の情報 */
  prefecture?: Prefecture;
};

/**
 * PostalCodeモデル
 * 郵便番号の情報
 */
export interface PostalCode {
  /** @example 1 */
  id?: number;
  /** @example "1234567" */
  code?: string;
  /** @example 1 */
  municipality_id?: number;
  /** @example "王子" */
  town?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  created_at?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  updated_at?: string;
}

/**
 * Prefectureモデル
 * 都道府県の情報
 */
export interface Prefecture {
  /** @example 1 */
  id?: number;
  /** @example "東京都" */
  name?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  created_at?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  updated_at?: string;
}

/**
 * Telphoneモデル
 * 電話番号
 */
export interface Telphone {
  /** @example 1 */
  id?: number;
  /** @example 1 */
  facility_id?: number;
  /** @example "0798772020" */
  number?: string;
}

/**
 * Userモデル
 * ユーザー情報
 */
export interface User {
  /** @example 1 */
  id?: number;
  /** @example "Ririko" */
  name?: string;
  /** @example "ririko@example.com" */
  email?: string;
  /** @example "member" */
  role?: "member" | "admin";
  /** @example 10 */
  address_id?: number;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  created_at?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  updated_at?: string;
}

/**
 * UserTokenモデル
 * ユーザーのトークン情報
 */
export interface UserToken {
  /** @example 1 */
  id?: number;
  /** @example 1 */
  user_id?: number;
  /** @example "eyJhbGciOiJI..." */
  token?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  expire_at?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  created_at?: string;
  /**
   * @format date-time
   * @example "2025-09-14T00:00:00Z"
   */
  updated_at?: string;
}

export type QueryParamsType = Record<string | number, any>;
export type ResponseFormat = keyof Omit<Body, "body" | "bodyUsed">;

export interface FullRequestParams extends Omit<RequestInit, "body"> {
  /** set parameter to `true` for call `securityWorker` for this request */
  secure?: boolean;
  /** request path */
  path: string;
  /** content type of request body */
  type?: ContentType;
  /** query params */
  query?: QueryParamsType;
  /** format of response (i.e. response.json() -> format: "json") */
  format?: ResponseFormat;
  /** request body */
  body?: unknown;
  /** base url */
  baseUrl?: string;
  /** request cancellation token */
  cancelToken?: CancelToken;
}

export type RequestParams = Omit<
  FullRequestParams,
  "body" | "method" | "query" | "path"
>;

export interface ApiConfig<SecurityDataType = unknown> {
  baseUrl?: string;
  baseApiParams?: Omit<RequestParams, "baseUrl" | "cancelToken" | "signal">;
  securityWorker?: (
    securityData: SecurityDataType | null,
  ) => Promise<RequestParams | void> | RequestParams | void;
  customFetch?: typeof fetch;
}

export interface HttpResponse<D extends unknown, E extends unknown = unknown>
  extends Response {
  data: D;
  error: E;
}

type CancelToken = Symbol | string | number;

export enum ContentType {
  Json = "application/json",
  JsonApi = "application/vnd.api+json",
  FormData = "multipart/form-data",
  UrlEncoded = "application/x-www-form-urlencoded",
  Text = "text/plain",
}

export class HttpClient<SecurityDataType = unknown> {
  public baseUrl: string = "http://localhost:8000";
  private securityData: SecurityDataType | null = null;
  private securityWorker?: ApiConfig<SecurityDataType>["securityWorker"];
  private abortControllers = new Map<CancelToken, AbortController>();
  private customFetch = (...fetchParams: Parameters<typeof fetch>) =>
    fetch(...fetchParams);

  private baseApiParams: RequestParams = {
    credentials: "same-origin",
    headers: {},
    redirect: "follow",
    referrerPolicy: "no-referrer",
  };

  constructor(apiConfig: ApiConfig<SecurityDataType> = {}) {
    Object.assign(this, apiConfig);
  }

  public setSecurityData = (data: SecurityDataType | null) => {
    this.securityData = data;
  };

  protected encodeQueryParam(key: string, value: any) {
    const encodedKey = encodeURIComponent(key);
    return `${encodedKey}=${encodeURIComponent(typeof value === "number" ? value : `${value}`)}`;
  }

  protected addQueryParam(query: QueryParamsType, key: string) {
    return this.encodeQueryParam(key, query[key]);
  }

  protected addArrayQueryParam(query: QueryParamsType, key: string) {
    const value = query[key];
    return value.map((v: any) => this.encodeQueryParam(key, v)).join("&");
  }

  protected toQueryString(rawQuery?: QueryParamsType): string {
    const query = rawQuery || {};
    const keys = Object.keys(query).filter(
      (key) => "undefined" !== typeof query[key],
    );
    return keys
      .map((key) =>
        Array.isArray(query[key])
          ? this.addArrayQueryParam(query, key)
          : this.addQueryParam(query, key),
      )
      .join("&");
  }

  protected addQueryParams(rawQuery?: QueryParamsType): string {
    const queryString = this.toQueryString(rawQuery);
    return queryString ? `?${queryString}` : "";
  }

  private contentFormatters: Record<ContentType, (input: any) => any> = {
    [ContentType.Json]: (input: any) =>
      input !== null && (typeof input === "object" || typeof input === "string")
        ? JSON.stringify(input)
        : input,
    [ContentType.JsonApi]: (input: any) =>
      input !== null && (typeof input === "object" || typeof input === "string")
        ? JSON.stringify(input)
        : input,
    [ContentType.Text]: (input: any) =>
      input !== null && typeof input !== "string"
        ? JSON.stringify(input)
        : input,
    [ContentType.FormData]: (input: any) => {
      if (input instanceof FormData) {
        return input;
      }

      return Object.keys(input || {}).reduce((formData, key) => {
        const property = input[key];
        formData.append(
          key,
          property instanceof Blob
            ? property
            : typeof property === "object" && property !== null
              ? JSON.stringify(property)
              : `${property}`,
        );
        return formData;
      }, new FormData());
    },
    [ContentType.UrlEncoded]: (input: any) => this.toQueryString(input),
  };

  protected mergeRequestParams(
    params1: RequestParams,
    params2?: RequestParams,
  ): RequestParams {
    return {
      ...this.baseApiParams,
      ...params1,
      ...(params2 || {}),
      headers: {
        ...(this.baseApiParams.headers || {}),
        ...(params1.headers || {}),
        ...((params2 && params2.headers) || {}),
      },
    };
  }

  protected createAbortSignal = (
    cancelToken: CancelToken,
  ): AbortSignal | undefined => {
    if (this.abortControllers.has(cancelToken)) {
      const abortController = this.abortControllers.get(cancelToken);
      if (abortController) {
        return abortController.signal;
      }
      return void 0;
    }

    const abortController = new AbortController();
    this.abortControllers.set(cancelToken, abortController);
    return abortController.signal;
  };

  public abortRequest = (cancelToken: CancelToken) => {
    const abortController = this.abortControllers.get(cancelToken);

    if (abortController) {
      abortController.abort();
      this.abortControllers.delete(cancelToken);
    }
  };

  public request = async <T = any, E = any>({
    body,
    secure,
    path,
    type,
    query,
    format,
    baseUrl,
    cancelToken,
    ...params
  }: FullRequestParams): Promise<HttpResponse<T, E>> => {
    const secureParams =
      ((typeof secure === "boolean" ? secure : this.baseApiParams.secure) &&
        this.securityWorker &&
        (await this.securityWorker(this.securityData))) ||
      {};
    const requestParams = this.mergeRequestParams(params, secureParams);
    const queryString = query && this.toQueryString(query);
    const payloadFormatter = this.contentFormatters[type || ContentType.Json];
    const responseFormat = format || requestParams.format;

    return this.customFetch(
      `${baseUrl || this.baseUrl || ""}${path}${queryString ? `?${queryString}` : ""}`,
      {
        ...requestParams,
        headers: {
          ...(requestParams.headers || {}),
          ...(type && type !== ContentType.FormData
            ? { "Content-Type": type }
            : {}),
        },
        signal:
          (cancelToken
            ? this.createAbortSignal(cancelToken)
            : requestParams.signal) || null,
        body:
          typeof body === "undefined" || body === null
            ? null
            : payloadFormatter(body),
      },
    ).then(async (response) => {
      const r = response as HttpResponse<T, E>;
      r.data = null as unknown as T;
      r.error = null as unknown as E;

      const data = !responseFormat
        ? r
        : await response[responseFormat]()
            .then((data) => {
              if (r.ok) {
                r.data = data;
              } else {
                r.error = data;
              }
              return r;
            })
            .catch((e) => {
              r.error = e;
              return r;
            });

      if (cancelToken) {
        this.abortControllers.delete(cancelToken);
      }

      if (!response.ok) throw data;
      return data;
    });
  };
}

/**
 * @title 子育てプロジェクト
 * @version 1.0.0
 * @baseUrl http://localhost:8000
 *
 * 子育てプロジェクトAPIドキュメント
 */
export class Api<
  SecurityDataType extends unknown,
> extends HttpClient<SecurityDataType> {
  example = {
    /**
     * No description
     *
     * @name 6Ff5011E74E207E292Cc306Ef0F253Aa
     * @summary Example endpoint
     * @request GET:/example
     * @secure
     */
    "6Ff5011E74E207E292Cc306Ef0F253Aa": (params: RequestParams = {}) =>
      this.request<void, any>({
        path: `/example`,
        method: "GET",
        secure: true,
        ...params,
      }),
  };
  api = {
    /**
     * @description メールアドレスとパスワードでログインし、認証トークンを返す
     *
     * @tags Auth
     * @name LoginUser
     * @summary ログイン
     * @request POST:/api/login
     * @secure
     */
    loginUser: (
      data: {
        /**
         * @format email
         * @example "test@example.com"
         */
        email: string;
        /**
         * @format password
         * @example "password123"
         */
        password: string;
      },
      params: RequestParams = {},
    ) =>
      this.request<
        {
          /** ユーザー情報 */
          user?: User;
          /** @example "1|eyJhbGciOiJIUzI1NiIsInR5cCI6" */
          token?: string;
        },
        {
          /** @example "認証が失敗しました。" */
          message?: string;
        }
      >({
        path: `/api/login`,
        method: "POST",
        body: data,
        secure: true,
        type: ContentType.Json,
        format: "json",
        ...params,
      }),

    /**
     * No description
     *
     * @tags Auth
     * @name LogoutUser
     * @summary ログアウト
     * @request DELETE:/api/logout
     * @secure
     */
    logoutUser: (params: RequestParams = {}) =>
      this.request<
        {
          /** @example "ログアウトしました。" */
          message?: string;
        },
        any
      >({
        path: `/api/logout`,
        method: "DELETE",
        secure: true,
        format: "json",
        ...params,
      }),

    /**
     * No description
     *
     * @tags Auth
     * @name PasswordResetRequest
     * @summary パスワードリセットメール送信
     * @request POST:/api/password/reset/request
     * @secure
     */
    passwordResetRequest: (
      data: {
        /**
         * @format email
         * @example "test@example.com"
         */
        email: string;
      },
      params: RequestParams = {},
    ) =>
      this.request<
        {
          /** @example true */
          mail_sent?: boolean;
        },
        {
          /** @example "メールアドレスが見つかりません。" */
          error?: string;
        }
      >({
        path: `/api/password/reset/request`,
        method: "POST",
        body: data,
        secure: true,
        type: ContentType.Json,
        format: "json",
        ...params,
      }),

    /**
     * No description
     *
     * @tags Auth
     * @name PasswordResetVerify
     * @summary パスワードリセット用トークンとメール検証
     * @request POST:/api/password/reset/verify
     * @secure
     */
    passwordResetVerify: (
      data: {
        /** @example "abc123token" */
        token: string;
        /**
         * @format email
         * @example "test@example.com"
         */
        email: string;
      },
      params: RequestParams = {},
    ) =>
      this.request<
        {
          /** @example true */
          verified?: boolean;
        },
        {
          /** @example "不正なトークンです。" */
          message?: string;
        }
      >({
        path: `/api/password/reset/verify`,
        method: "POST",
        body: data,
        secure: true,
        type: ContentType.Json,
        format: "json",
        ...params,
      }),

    /**
     * No description
     *
     * @tags Auth
     * @name PasswordReset
     * @summary パスワード更新
     * @request POST:/api/password/reset
     * @secure
     */
    passwordReset: (
      data: {
        /** @example "abc123token" */
        token: string;
        /**
         * @format email
         * @example "test@example.com"
         */
        email: string;
        /**
         * @format password
         * @example "newPassword123"
         */
        password: string;
      },
      params: RequestParams = {},
    ) =>
      this.request<
        {
          /** @example "パスワードを更新しました。" */
          message?: string;
        },
        {
          /** @example "不正なトークンです。" */
          message?: string;
        }
      >({
        path: `/api/password/reset`,
        method: "POST",
        body: data,
        secure: true,
        type: ContentType.Json,
        format: "json",
        ...params,
      }),

    /**
     * @description ユーザーの新規登録を行う
     *
     * @tags Register
     * @name SignUpUser
     * @summary 新規登録
     * @request POST:/api/register
     * @secure
     */
    signUpUser: (
      data: {
        /** @example "test User" */
        name: string;
        /**
         * @format email
         * @example "test@example.com"
         */
        email: string;
        /**
         * @format password
         * @example "password123"
         */
        password: string;
      },
      params: RequestParams = {},
    ) =>
      this.request<
        {
          /** ユーザー情報 */
          user?: User;
          /** @example "1|eyJhbGciOiJIUzI1NiIsInR5cCI6" */
          token?: string;
        },
        any
      >({
        path: `/api/register`,
        method: "POST",
        body: data,
        secure: true,
        type: ContentType.Json,
        format: "json",
        ...params,
      }),

    /**
     * @description ユーザーが退会処理をする
     *
     * @tags Register
     * @name DeleteAccount
     * @summary 退会
     * @request DELETE:/api/delete-account
     * @secure
     */
    deleteAccount: (params: RequestParams = {}) =>
      this.request<
        {
          /** @example "ログアウトしました。" */
          message?: string;
        },
        any
      >({
        path: `/api/delete-account`,
        method: "DELETE",
        secure: true,
        format: "json",
        ...params,
      }),

    /**
     * @description 施設一覧の取得
     *
     * @tags Facility
     * @name FacilitiesInfo
     * @summary 施設一覧
     * @request GET:/api/facilities
     * @secure
     */
    facilitiesInfo: (
      query?: {
        /**
         * 施設名での検索キーワード
         * @example "北区"
         */
        name?: string;
      },
      params: RequestParams = {},
    ) =>
      this.request<
        {
          facilities?: Facility[];
        },
        any
      >({
        path: `/api/facilities`,
        method: "GET",
        query: query,
        secure: true,
        format: "json",
        ...params,
      }),

    /**
     * @description 施設詳細の取得
     *
     * @tags Facility
     * @name FacilityInfo
     * @summary 施設詳細
     * @request GET:/api/facilities/{id}
     * @secure
     */
    facilityInfo: (id: number, params: RequestParams = {}) =>
      this.request<
        {
          /** 施設情報 */
          facility?: Facility;
        },
        {
          /** @example "該当の施設が見つかりません。" */
          message?: string;
        }
      >({
        path: `/api/facilities/${id}`,
        method: "GET",
        secure: true,
        format: "json",
        ...params,
      }),

    /**
     * @description 現在のユーザー自身の取得
     *
     * @tags User
     * @name MyProfile
     * @summary 現在のユーザー自身
     * @request GET:/api/profile
     * @secure
     */
    myProfile: (params: RequestParams = {}) =>
      this.request<
        {
          /** ユーザー情報 */
          user?: User;
        },
        any
      >({
        path: `/api/profile`,
        method: "GET",
        secure: true,
        format: "json",
        ...params,
      }),
  };
}
