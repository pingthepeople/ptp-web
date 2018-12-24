:: Create Passport public/private keys from the app settings (environment).

echo Writing public key from OAUTH_PUBLIC_KEY to D:\home\site\wwwroot\storage\oauth-public.key...
echo %OAUTH_PUBLIC_KEY% > D:\home\site\wwwroot\storage\oauth-public.key

echo Writing private key from OAUTH_PRIVATE_KEY to D:\home\site\wwwroot\storage\oauth-private.key...
echo %OAUTH_PRIVATE_KEY% > D:\home\site\wwwroot\storage\oauth-private.key