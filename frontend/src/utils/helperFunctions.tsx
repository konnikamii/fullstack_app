// Functions used often

export function obfuscateEmail(email: string): string {
  const [localPart, domain] = email.split("@");
  const obfuscatedLocalPart =
    localPart.length > 2
      ? localPart.slice(0, 2).replace(/./g, "*") + localPart.slice(2)
      : localPart.replace(/./g, "*");
  return `${obfuscatedLocalPart}@${domain}`;
}

export function formatTimestamp(timestamp: string): string {
  const date = new Date(timestamp);
  const options: Intl.DateTimeFormatOptions = {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
    timeZoneName: "short",
  };
  return date.toLocaleDateString(undefined, options);
}
