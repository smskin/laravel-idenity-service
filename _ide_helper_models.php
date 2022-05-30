<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace SMSkin\IdentityService\Models{
/**
 * SMSkin\IdentityService\Models\Scope
 *
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \SMSkin\IdentityService\Models\ScopeGroup $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\SMSkin\IdentityService\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Scope newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scope newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scope query()
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scope whereUpdatedAt($value)
 */
	class Scope extends \Eloquent {}
}

namespace SMSkin\IdentityService\Models{
/**
 * SMSkin\IdentityService\Models\ScopeGroup
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\SMSkin\IdentityService\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup s()
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScopeGroup whereUpdatedAt($value)
 */
	class ScopeGroup extends \Eloquent {}
}

namespace SMSkin\IdentityService\Models{
/**
 * SMSkin\IdentityService\Models\User
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $identity_uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\SMSkin\IdentityService\Models\UserEmailCredential[] $emailCredentials
 * @property-read int|null $email_credentials_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\SMSkin\IdentityService\Models\UserOAuthCredential[] $oauthCredentials
 * @property-read int|null $oauth_credentials_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\SMSkin\IdentityService\Models\UserPhoneCredential[] $phoneCredentials
 * @property-read int|null $phone_credentials_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User groups()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User s()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdentityUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \SMSkin\IdentityServiceClient\Models\Contracts\HasIdentity {}
}

namespace SMSkin\IdentityService\Models{
/**
 * SMSkin\IdentityService\Models\UserEmailCredential
 *
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \SMSkin\IdentityService\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\SMSkin\IdentityService\Models\UserEmailVerification[] $verifications
 * @property-read int|null $verifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailCredential whereVerifiedAt($value)
 */
	class UserEmailCredential extends \Eloquent {}
}

namespace SMSkin\IdentityService\Models{
/**
 * SMSkin\IdentityService\Models\UserEmailVerification
 *
 * @property int $id
 * @property int $user_id
 * @property int $credential_id
 * @property string $email
 * @property string $code
 * @property bool $is_canceled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \SMSkin\IdentityService\Models\UserEmailCredential $credential
 * @property-read \SMSkin\IdentityService\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification active()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification whereCredentialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification whereIsCanceled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailVerification whereUserId($value)
 */
	class UserEmailVerification extends \Eloquent {}
}

namespace SMSkin\IdentityService\Models{
/**
 * SMSkin\IdentityService\Models\UserOAuthCredential
 *
 * @property int $id
 * @property \App\Modules\OAuth\Enums\DriverEnum $driver
 * @property string $remote_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \SMSkin\IdentityService\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential whereRemoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOAuthCredential whereUserId($value)
 */
	class UserOAuthCredential extends \Eloquent {}
}

namespace SMSkin\IdentityService\Models{
/**
 * SMSkin\IdentityService\Models\UserPhoneCredential
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \SMSkin\IdentityService\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\SMSkin\IdentityService\Models\UserPhoneVerification[] $verifications
 * @property-read int|null $verifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneCredential newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneCredential newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneCredential query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneCredential whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneCredential whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneCredential wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneCredential whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneCredential whereUserId($value)
 */
	class UserPhoneCredential extends \Eloquent {}
}

namespace SMSkin\IdentityService\Models{
/**
 * SMSkin\IdentityService\Models\UserPhoneVerification
 *
 * @property int $id
 * @property string $phone
 * @property string $code
 * @property bool $is_canceled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \SMSkin\IdentityService\Models\UserPhoneCredential|null $credential
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification active()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification whereIsCanceled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhoneVerification whereUpdatedAt($value)
 */
	class UserPhoneVerification extends \Eloquent {}
}

