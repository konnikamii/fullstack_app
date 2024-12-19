// Types and Interfaces for TypeScript

export interface Form {
  name: string;
  email: string;
  subject: string;
  message: string;
}
export interface FormErrors {
  name: string | null;
  email: string | null;
  subject: string | null;
  message: string | null;
}


export interface ValidationError {
  [key: string]: string[];
}

export interface ApiResponse {
  success: boolean;
  errors?: ValidationError;
}

export interface ContactsGet {
  data: {
    id: number,
    name: string,
    email: string,
    subject: string,
    message: string,
    created_at: string,
    updated_at: string
  }[]
}